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


$accpeted_statuses = ['New', 'Current', 'Final'];


render_page(function() use ($infos) {
	$status_change = $_GET['status_change'] ?? '';
    $status_change_to = $_GET['status_change_to'] ?? '';
    $confirm_change = $_POST['confirm_change'] ?? '';

    //var_dump($status_change, $status_change_to, $confirm_change);
    

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
                <h2>Change Status: </h2>
                <form method="GET" action=""
                    <label></label>
                    <input type="text" 
                    name="status_change" 
                    placeholder="user_name: Bob..." value="' . html_sanitize($status_change) . '"
                >

                    <select name="status_change_to">
                        <option value="New">New</option>
                        <option value="Current">Current</option>
                        <option value="Final">Final</option>
                    </select>
                    <input type="Submit" value="Change status">
                </form>

                <p>Other tools:</p>
                <button onclick="window.location.href=\'/manage\'">Search</button>
                <button onclick="window.location.href=\'/manager/delete\'">Delete</button>
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

    if ($status_change) {
        echo '
            <form method="POST" action="">
                <label>Are you sure you want to change these eois to "' . $status_change_to . '"?</label>
                <input type="Submit" name="confirm_change" value="Confirm Change">
            </form>
            ';

        $terms = explode(';', $status_change);

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

            if ($status_change && $status_change_to && $confirm_change) {
                $db = Database::get();
                $db->query('UPDATE eoi SET status = ? WHERE id = ?', [$status_change_to, $info['id']]);
                $info['status'] = $status_change_to;
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
