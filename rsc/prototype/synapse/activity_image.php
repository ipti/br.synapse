<?php
	session_start();

    $host = 'lapacer:C:\docs\synapse\Snp_2.1\SYNAPSE.FDB';

    $username = 'SYSDBA';
    $password = 'masterkey';
    
    $dbh = pg_connect($host, $username, $password);

				$SQL2 = "SELECT data FROM image where image = ".$data_cod."";
				//echo $SQL2;
				$res2 = pg_query($SQL2);
				//$linha2 = pg_fetch_row($res2);
				if ($row = pg_fetch_row($res2)) {
					//  $blob_data = pg_blob_info($row[0]);
					$blob_hndl = pg_blob_open($row[0]);
					//  $image = pg_blob_get( $blob_hndl, $blob_data[0]);	
					//$image = pg_blob_get($blob_hndl,8192);
					while($data = pg_blob_get($blob_hndl, 8192)){ 
						$image .= $data; 
					}
				}
				echo $image;
				//session_register('image');
?>
