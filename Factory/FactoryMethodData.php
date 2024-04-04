<?php

class Data{
    private string $type;
    private string $content;
    public function __construct(string $type, string $content){
        $this->type = $type;
        $this->content = $content;
    }
    public function getType(): string{
        return $this->type;
    }
    public function getContent(): string{
        return $this->content;
    }
}

abstract class DataProcessor{
    abstract public function createDataProcessor(Data $data);
}

class VideoDataProcessor extends DataProcessor {
    public function createDataProcessor(Data $data){
        $db = new SQLite3('database.sqlite3');

        if ($data->getType() !== 'video') {
            throw new Exception("Invalid data type for VideoDataProcessor");
        }
        $db->exec("CREATE TABLE IF NOT EXISTS videos (id INTEGER PRIMARY KEY,video TEXT)");
        $videoPath = $data->getContent();
        $statement = $db->prepare("INSERT INTO videos (video) VALUES (?)");
        $statement->bindValue(1, $videoPath, SQLITE3_TEXT);
        $statement->execute();
        echo "Video data processed\n";
    }
}

class ImageDataProcessor extends DataProcessor {
    public function createDataProcessor(Data $data){
        $db = new SQLite3('database.sqlite3');

        if ($data->getType() !== 'image') {
            throw new Exception("Invalid data type for ImageDataProcessor");
        }
        $db->exec("CREATE TABLE IF NOT EXISTS images (id INTEGER PRIMARY KEY,image TEXT)");
        $imagePath = $data->getContent();
        $statement = $db->prepare("INSERT INTO images (image) VALUES (?)");
        $statement->bindValue(1, $imagePath, SQLITE3_TEXT);
        $statement->execute();
        echo "Image data processed\n";
    }
}

class AudioDataProcessor extends DataProcessor {
    public function createDataProcessor(Data $data){
        $db = new SQLite3('database.sqlite3');

        if ($data->getType() !== 'audio') {
            throw new Exception("Invalid data type for AudioDataProcessor");
        }
        $db->exec("CREATE TABLE IF NOT EXISTS audios (id INTEGER PRIMARY KEY,audio TEXT)");
        $audioPath = $data->getContent();
        $statement = $db->prepare("INSERT INTO audios (audio) VALUES (?)");
        $statement->bindValue(1, $audioPath, SQLITE3_TEXT);
        $statement->execute();
        echo "Audio data processed\n";
    }
}

class DataProcessorCreator{
    private DataProcessor $dataProcessor;

    public function setProcessor(DataProcessor $dataProcessor){
        $this->dataProcessor = $dataProcessor;
    }

    public function processData(Data $data){
        $this->dataProcessor->createDataProcessor($data);
    }
}

$dataProcessorCreator = new DataProcessorCreator();
$dataProcessorCreator->setProcessor(new VideoDataProcessor());
$dataProcessorCreator->processData(new Data('video', '/home/temirlan/Загрузки/test.mp4'));

$dataProcessorCreator = new DataProcessorCreator();
$dataProcessorCreator->setProcessor(new ImageDataProcessor());
$dataProcessorCreator->processData(new Data('image', '/home/temirlan/Загрузки/test.jpg'));
