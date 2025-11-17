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


    echo 
    '
    <section id="outer-box" class="flex flex-y">
        <div id="tool-box" class = "flex flex-o">
            <aside id="search-bar" class="flex-y box">
                <form method="GET" action=""
                    <label>Delete: </label><br>
                    <input type="text" 
                    name="delete" 
                    placeholder="user_name: Bob..." value="' . html_sanitize($delete) . '"
                >

                    <input type="Submit" value="Delete">
                </form>

                <h3>Other tools:</h3>
                <button onclick="window.location.href=\'/manage\'">Search</button>
                <button onclick="window.location.href=\'/manager/changestatus\'">Change status</button>
            </aside>

            <aside id="guide-bar" class="flex-y box">
                <p>Tag guide: </p>
                <ul>
                    <li>Use tag "job_id:" to filter for jobs ("job: VKE99, ZBA91;") </li>
                    <li>Use tag "user_id:" to filter specific applicant id ("user_id: 24125;")</li>
                    <li>Use tag "first_name:" to filter specific first name ("first_name: Bob, Jake;")</li>
                    <li>Other tags: last_name</li>
                </ul>
            </aside>
        </div>

        <div id="listing-eois" class="fill flex-y box">' ;

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
