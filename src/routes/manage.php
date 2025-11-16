<?php
$db = Database::get();
$entry = [];
$section = [];

foreach ($db->query('SELECT * FROM eoi') as $row) {
    
}

render_page(function() {
	echo 
    '<aside id="tools-bar" class="flex-y box"><ul>
        <form method="GET" action="search_result.php">
            <label>Search:</label>
            <br>
            <input type="text" name="model" required>
            <input type="submit" value="Search">
        </form>
        <p>Search guide: </p>
        <ul>
            <li>Use tag "job:" to filter for jobs ("jobs: VKE99, ZBA91;") </li>
            <li>Use tag "user_id:" to filter specific applicant id ("user_id: 24125;")</li>
            <li>Use tag "user_name:" to filter specific applicant name ("user_name: Bob, Jake;")</li>
        </ul>
    </aside>

    <div id="listing-eois" class="fill flex-y box">';
    foreach ($sections as $section) { render('eoi/section', $section); }
    echo '</div>';
	
},
	title: 'Management',
	style: 'manage',
);
