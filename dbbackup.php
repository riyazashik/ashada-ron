
<?php
//phpinfo();exit;
#Function to backup database to a zip file
removeoldbackups();
backup();
function backup() 
{
  $username = 'facelook_ashada';
  $password = '$%5}#+]DQI%D';
  $db = 'facelook_ashada';

  $suffix = time();
  $date = date('Ymd');
 // removeoldbackups();
exec("mysqldump -u $username -p$password $db | gzip > ashada1.greymatterx.com/dbbackups/$db"."$date.sql.gz");
//exec("mysqldump -u $username -p$password $db | gzip > $db"."$date.sql.gz");
}


function removeoldbackups(){
  $olddate = date('Ymd', strtotime('-7 days', strtotime(date('Y-m-d'))));
  $removefile = 'facelook_ashada'.$olddate.'.sql.gz';
  if(file_exists('ashada1.greymatterx.com/dbbackups/'.$removefile)){
    unlink('ashada1.greymatterx.com/dbbackups/'.$removefile);
  }
}


?>