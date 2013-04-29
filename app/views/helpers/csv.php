<?php
class CsvHelper extends AppHelper {

    var $delimiter = ',';
    var $enclosure = '"';
    var $filename = 'Export.csv';
    var $raw_data;

    function headers($content_type) {
        header("Content-type:$content_type;");
        header("Content-disposition:attachment;filename=" . $this->filename);
    }

    function addCell($value) {
        $this->raw_data .= $this->enclosure . $value . $this->enclosure . $this->delimiter;
    }

    function endRow() {
        $this->raw_data = substr($this->raw_data, 0, strrpos($this->raw_data, $this->delimiter)) . "\n";
    }

    function addRow($row) {
        foreach($row as $cell) {
            $this->addCell($cell);
        }
        $this->endRow();
    }

    function setFilename($filename) {
        $this->filename = $filename;
        if (strtolower(substr($this->filename, -4)) != '.csv') {
            $this->filename .= '.csv';
        }
    }

    function serialize($data, $add_header_row = true) {
        $row_number = 1;
        foreach($data as $listing) {
            foreach($listing as $model_name => $model_data) {
                foreach ($model_data as $field_name => $field_value) {
                    if ($row_number == 1) {
                        $headerRow[] = $field_name;
                        $firstRow[] = $field_value;
                    } else {
                        $this->addCell($field_value);
                    }
                }
            }
            if ($row_number == 1) {
                $this->addRow($headerRow);
                $this->addRow($firstRow);
                unset($headerRow);
                unset($firstRow);
            } else {
                $this->endRow();
            }
            $row_number++;
        }
    }

	//dpr($field_name);exit;

    function download($filename = null, $content_type = "application/vnd.ms-excel") {
        if ($filename) {
            if (is_string($filename)) $this->setFilename($filename);
        }
        $this->headers($content_type);
        echo utf8_decode($this->raw_data);
    }

    function toString() {
        header("Content-type:text/plain;");
        echo utf8_decode($this->raw_data);
    }

}

?>