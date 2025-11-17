<?php



function guide_bar() : string {
    $guide_bar_ =
    '       <aside id="guide-bar" class="flex-y box">
                <p>Tag guide: </p>
                <ul>
                    <li>Use tag "job_id:" to filter for jobs ("job: VKE99, ZBA91;") </li>
                    <li>Use tag "user_id:" to filter specific applicant id ("user_id: 24125;")</li>
                    <li>Use tag "first_name:" to filter specific first name ("first_name: Bob, Jake;")</li>
                    <li>Other tags: last_name</li>
                </ul>
            </aside>';
    return $guide_bar_;
}

function other_tools(bool $search, $delete, $change): string {
    $other_tools_ = '
    <article id="other-tools" class="flex-y box">
        <p>Other tools</p>
        <details class="flex flex-y other-tools-details">
            <summary></summary>
            <hr>
    ';

    if ($search) {
        $other_tools_ .= '<button onclick="window.location.href=\'/manage\'">Search</button>';
    }

    if ($delete) {
        $other_tools_ .= '<button onclick="window.location.href=\'/manager/delete\'">Delete</button>';
    }

    if ($change) {
        $other_tools_ .= '<button onclick="window.location.href=\'/manager/changestatus\'">Change status</button>';
    }

    $other_tools_ .= '
            <hr>
        </details>
    </article>
    ';

    return $other_tools_;
}


function search_head_html(string $h2val, $searchBarName, $search, $extra_search, $extra_delete, $extra_change, bool $dropdownChange) : string {
    $searchTags = [
        'job_id:' => 'job_id', 
        'user_id:'  => 'user_id', 
        'first_name:'  => 'first_name', 
        'last_name:'  => 'last_name', 
    ];


    $search_func = '
    <section id="outer-box" class="flex flex-y">
        <div id="tool-box" class = "flex flex-o">
            <aside id="search-bar" class="flex-y box">
                <h2>' . $h2val . '</h2>
                <form method="GET" action=""
                    <label></label>
                    <input type="text" 
                    name="search" 
                    placeholder="user_name: Bob..." value="' . html_sanitize($search) . '"
                >
                ';
    if ($dropdownChange) {
        $search_func .= '
                    <select name="status_change_to">
                        <option value="New">New</option>
                        <option value="Current">Current</option>
                        <option value="Final">Final</option>
                    </select>
                    <input type="Submit" value="Change status">
        ';
    }

    $search_func .= '
                    <input type="Submit" value="' . $searchBarName . '">
                </form>

                '. other_tools($extra_search, $extra_delete, $extra_change) .'
                
            </aside>

            '. guide_bar() .'
            
        </div>

        <div id="listing-eois" class="fill flex-y box"> 
    ';

    return $search_func;
}



























































































































































































function manager_racist(string $blacknigger) {
    echo "hey!" . $blacknigger;
}




