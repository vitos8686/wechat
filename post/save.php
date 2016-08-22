<?php  
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$imya = $request->imya;
    @$wechat = $request->wechat;
    @$email = $request->email;
    @$post_content = $request->post_content;
    
    
   
$message = $imya.$wechat.$email.$post_content;


$content = '<br>Контактные данные: <br>'.'Имя: '.$imya.'<br>'.'Телефон: '.$wechat.'<br>'.'Email: '.$email.'<br>'.'Описание груза: '.$post_content.'<br>';

$subject = 'Test'; 

$to = 'vitos8686@mail.ru';
$headers .= "From: Birthday Reminder <admin@laowai-china.com>\r\n";

 mail( $to, $subject, $content, $headers);

//конец отправки почты

	
	
?>
