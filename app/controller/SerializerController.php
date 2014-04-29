<?php

class SerializerController extends Controller {
    

    public function actionIndex() {
        $this->title = "Serializer";
        $this->description = 'Allows to easily perform array serialization (also to json).';
        
        $serializer = Model::factory('serializer');
        $inFormats = $serializer->inputFormats;
        $outFormats = $serializer->outputFormats;
        $data = [];
        $result = false;

        if (!empty($_POST['data'])) {
            $data = $_POST['data'];

            if (get_magic_quotes_gpc()) {
                $data['source'] = stripslashes($data['source']);
            } else {
                $data['source'] = $data['source'];
            }

            try {
                $result = $serializer->convert($data);
            } catch (Exception $ex) {
                $result = $ex->getMessage();
                $error = true;
            }
        }
        $this->render('serializer', [
            'inFormats' => $inFormats,
            'outFormats'=> $outFormats,
            'data' => $data,
            'result' => $result
        ]);
    }
}