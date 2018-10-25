<?php

function sendReport($write_file_name, $dateToday)
{
    if (file_exists($write_file_name)) {
        $filename = basename($write_file_name);
        $send_to = "xyz@gmail.com";
        $sep = md5(time());

        $filedata1 = file_get_contents($write_file_name);
        $fdata1    = chunk_split(base64_encode($filedata1)); //Encode data into text form
        
        $header = "";
        $header .= "From:abc@gmail.com \r\n";
        $header .= "MIME-Version: 1.0\n";
        $header .= "Content-Type: multipart/related;\r\tboundary=\"$sep\"\n";
        $header .= "Importance: normal\n";
        $header .= "Priority: normal\n";

        $message  = "";
        $message .= "--$sep\n";
        $message .= "Content-Type: multipart/alternative;\r\tboundary=\"New$sep\"\n";
        $message .= "--New$sep\n";
        $message .= "Content-Type: text/html;\r charset=UTF-8\n";
        $message .= "MIME-Version: 1.0\n";
        $message .= "Content-Transfer-Encoding: 7bit\n\n";
        $message .= "The attachement contains list of possible duplicates which were not unpublished(college athletic teams issue).\n\n";
        $message .= "--New$sep--\n\n";
        $message .= "--$sep\n";
        $message .= "Content-Type:application/vnd.ms-excel;\r name=\"$filename\"\n";
        $message .= "MIME-Version: 1.0\n";
        $message .= "Content-Transfer-Encoding: base64\n";
        $message .= "Content-Disposition:attachment;\r filename=\"$filename\"\n\n";
        $message .= "$fdata1\n";
        $message .= "--$sep--\n\n";
        
        $subject = "College Athletic Teams Reports - $dateToday";
        if (mail($send_to, $subject, $message, $header)) {
            echo "EMAIL SENT SUCCESSFULLY!!!";
        }
    }
}

?>
