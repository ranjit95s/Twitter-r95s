<?php 

    include '../init.php';
    $getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

    if(isset($_POST['search']) && !empty($_POST['search'])){
        $search = $getFromU->checkInput($_POST['search']);
        $result = $getFromU->search($search);
        $resultTweets = $getFromT->searchTCount($search);

        if(!empty($search)){
        echo ' <div class="nav-right-down-wrap"><ul>';

        foreach($result as $user){
            echo ' <li>
                        <div class="nav-right-down-inner">
                        <div class="nav-right-down-left">
                            <a href="'.BASE_URL.$user->username.'"><img src="'.BASE_URL.$user->profileImage.'"></a>
                        </div>
                        <div class="nav-right-down-right">
                            <div class="nav-right-down-right-headline">
                                <a href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a><br><span>@'.$user->username.'</span>
                            </div>
                            <div class="nav-right-down-right-body">
                            
                            </div>
                        </div>
                    </div> 
                </li> ';
        }
        
        
        echo '</ul>
        '.(($getFromT->searchTCount($search) != 0) ? '
        <div class="tweetSearch" style="padding: 5px;
        width: 100%;
        font-size: 1.1rem;">  <a style="    color: var( --primary-text-color);
        text-decoration: none;" href="'.BASE_URL.'search/'.$search.'">'.$search.'</a> <div class="tweetCount" style="    color: #bfbfbf;
        margin-top: 5px;
        font-size: 0.9rem;">'.$getFromT->searchTCount($search).' Tweets</div> </div>
        ' : ' <div class="noResult ellipsis" style="    color:  var( --secondary-text-color);
        padding: 5px;
        width:98%;
        margin-bottom: 5px;
        font-size: 1rem;
        margin-top: 5px;"> No Result Found On "<span style="    color: var( --primary-text-color);
        font-weight: 600;">'.$search.'</span>" </div> ').'
        </div> 
        ';
    }
   
    }

?>