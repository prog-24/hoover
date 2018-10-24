<?php
/**
 * Created by PhpStorm.
 * User: aitspeko
 * Date: 24/10/2018
 * Time: 10:10
 */

namespace Promise\Hoover;


use Symfony\Component\HttpKernel\Exception\HttpException;

class RoomController
{
    public function go()
    {
        try {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);
            if(empty($data['roomsize'])) {
                throw new HttpException(422, "You must specify the `roomsize` parameter");
            }
            $room = new Grid($data['roomsize'][0], $data['roomsize'][1]);
            $hoover = $room->getItemsOfType(Hoover::class)[0];
            if(empty($hoover)) {
                $hoover = new Hoover("Room Cleaner");
                $room->registerHoover($hoover);
            }
            if(!empty($data['coords'])) {
                $hoover->setPosition(new GridPosition($data['coords'][0], $data['coords'][1]));
            }
            if(!empty($data['patches'])) {
                foreach ($data['patches'] as $patch) {
                    $dirt = new Dirt(new GridPosition($patch[0], $patch[1]));
                    $room->registerDirt($dirt);
                }
            }

            $results = $room->clean($hoover);
            echo json_encode($results);
            unset($room);
        } catch (\Exception $e) {
            if($e instanceof HttpException) {
                $errorCode = $e->getStatusCode();
            } else {
                $errorCode = 500;
            }
            http_response_code($errorCode);
            $data = [
                "error" => $e->getMessage(),
                "code" => $e->getCode()
            ];
            echo json_encode($data);
        }
    }
}