<?php


class Convert_Task {

	function run(){

		$files = Fil3::where("type", "=", "map")->where("converted", "=", "0")->get();

		foreach($files as $file){
			$event = $file->event()->first();

			system("convert -density 300 {$file->url} /tmp/map-{$file->event_id}.jpg");
			if(!is_file('/tmp/map.jpg')) continue;

			$filepath = $event->s3_slug."/map.jpg";

			S3::putObject(S3::inputFile("/tmp/map-{$file->event_id}.jpg", false), "s3.obj.no", $filepath, S3::ACL_PUBLIC_READ);
			unlink("/tmp/map-{$file->event_id}.jpg");

			$child = new Fil3;
			$child->type = "jpg-map";
			$child->converted = '1';
			$child->event_id = $event->id;
			$child->filename = "map.jpg";
			$child->s3_path = $filepath;
			$child->url = "http://s3.obj.no/".$filepath;
			$file->childs()->insert($child);

			$file->converted = '1';
			$file->save();
		}

		return true;
	}
}