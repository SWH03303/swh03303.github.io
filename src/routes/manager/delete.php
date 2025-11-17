<?php
Session::require_user(true);

$db = Database::get();
$infos = [];

foreach ($db->query('SELECT * FROM eoi') as $row) {
    $applicant_info = $db->query('SELECT * FROM user_applicant WHERE id = ?', [$row['user_id']]);
    $infos[] = $row + ['applicant_info' => $applicant_info];
}
//exit;


$delete = $_GET['delete'] ?? '';
$confirm_delete = $_POST['confirm_delete'] ?? '';
$status_change = $_GET['status_change'] ?? '';
$confirm_change = $_POST['confirm_change'] ?? '';
$accpeted_statuses = ['New', 'Current', 'Final'];


render_page(function() use ($infos) {
	$delete = $_GET['delete'] ?? '';
    $confirm_delete = $_POST['confirm_delete'] ?? '';

    $searchTags = [
        'job_id:' => 'job_id', 
        'user_id:'  => 'user_id', 
        'first_name:'  => 'first_name', 
        'last_name:'  => 'last_name', 
    ];

    echo search_head_html('Delete: ', 'Delete', $delete, true, false, true , false);
    if ($delete) {
        echo '
            <form method="POST" action="">
                <label>Are you sure you want to delete these eois?</label>
                <input type="Submit" name="confirm_delete" value="Confirm Delete">
            </form>
            ';

        $terms = explode(';', $delete);

        $filtered = $infos;

        foreach ($searchTags as $tag => $infoKey) {
            foreach ($terms as $term) {
                $term = trim($term);
                if (str_starts_with($term, $tag)) {
                    $extractedInfo = array_map('trim', explode(',', substr($term, strlen($tag))));

                    

                    $filtered = 
                    array_filter($filtered, function($info) use ($extractedInfo, $infoKey) {
                        if (array_key_exists($infoKey, $info)) {
                            return in_array($info[$infoKey], $extractedInfo);
                        }

                        if (isset($info['applicant_info'][0]) && array_key_exists($infoKey, $info['applicant_info'][0])) {
                            return in_array($info['applicant_info'][0][$infoKey], $extractedInfo);
                        }

                        return false;
                    });
                }
            }

            
        }

        foreach ($filtered as $info) { 
            if ($delete && $confirm_delete) {
                $db = Database::get();
                $db->query('DELETE FROM eoi WHERE id = ?', [$info['id']]);
            } 
            render('eoi/eoi_info', $info); 
        }
    } else {
        
        foreach ($infos as $info) { 
            render('eoi/eoi_info', $info); 
        }
    }

    echo '
        </div>
    </section>
    ';
	
},
	title: 'Management',
	style: 'manage',
);
