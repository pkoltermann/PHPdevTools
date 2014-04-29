<?php

class UrlencodeController extends Controller {
    public function actionIndex() {
        $this->title = "UrlEncode";
        $this->description = 'Allows to easily perform encoding and decoding urls.';
        $this->render('urlencode', [
        ]);
    }
}