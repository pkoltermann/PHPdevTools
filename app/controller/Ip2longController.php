<?php

class Ip2longController extends Controller {
    public function actionIndex() {
        $this->title = "IP2Long";
        $this->description = 'Allows to easily save IPv4 as integer.';        
        $data = [];
        $result = false;

        if (!empty($_POST['data'])) {
            $data = $_POST['data'];

            try {
                if($data['operation'] === 'decode') {
                    $result = long2ip($data['source']);
                } else {
                    $result = ip2long($data['source']);
                }
            } catch (Exception $ex) {
                $result = $ex->getMessage();
                $error = true;
            }
        }
        $this->render('ip2long', [
            'data' => $data,
            'result' => $result,
            'operations' => ['decode', 'encode'],
        ]);
    }
}