<?php

class UrlencodeController extends Controller {
    public function actionIndex() {
        $this->title = "UrlEncode";
        $this->description = 'Allows to easily perform encoding and decoding urls.';        
        $data = [];
        $result = false;

        if (!empty($_POST['data'])) {
            $data = $_POST['data'];

            if (get_magic_quotes_gpc()) {
                $data['source'] = stripslashes($data['source']);
            }

            try {
                if($data['operation'] === 'decode') {
                    $result = urldecode($data['source']);
                } else {
                    $result = urlencode($data['source']);
                }
            } catch (Exception $ex) {
                $result = $ex->getMessage();
                $error = true;
            }
        }
        $this->render('urlencode', [
            'data' => $data,
            'result' => $result,
            'operations' => ['decode', 'encode'],
        ]);
    }
}