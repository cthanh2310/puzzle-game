<?php
    $p = [[0,0], ['x' => 1, 'y' => 1], ['x' => 1, 'y' => 2], ['x' => 1, 'y' => 3], ['x' => 2, 'y' => 1], 
                ['x' => 2, 'y' => 2], ['x' => 2, 'y' => 3], ['x' => 3, 'y' => 1], ['x' => 3, 'y' => 2], ['x' => 3, 'y' => 3] ];

    $O = [];
    // $start = $_GET['startState'];
    // $start = json_decode($start, true);
    // unset($start[0]);
  
 //   echo json_encode($start);

     $start = [1 => 1, 2 => 8, 3 => 3,
               4 => 4, 5 => 9, 6 => 6, 
               7 => 2, 8 => 5, 9 => 7];

  //  $start = [1 => 2, 2 => 9, 3 => 3, 4 => 1, 5 => 5, 6 => 6, 7 => 4, 8 => 7, 9 => 8];
 //  $start = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9];
  //   echo json_encode($start);
   //  die();
    $goal = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9];

    $ninePosition = array_search(9, $start, true); 

    array_push($O, ['currentState' => $start, 
                    'ninePos' => $ninePosition, 
                    'pathCost' => 0,
                    'Mahattan' => calculateMahattan($start),
                    'parentID' => null,
                    'nodeStatus' => 'inQueue'] );
    
    while ( array_search('inQueue', array_column($O, 'nodeStatus' ), true) >= 0) {
        $n = nodeHasMinMahattanDistance();
        // echo '<pre>';
        // print_r($n);
        // echo '</pre>';

        if ($n['currentState'] === $goal) {
            // echo '<br>END: <pre>';
            // print_r($n);
            // echo '</pre>';

            trace($n);
            break;
        }
        
        go($n, 'right');
        go($n, 'left');
        go($n, 'up');
        go($n, 'down');

        //  echo "<pre>";
        //  print_r($O);
        //  echo "</pre>";        
    }

    function go($n, $direction) {
        $ninePosition = $n['ninePos'];
        $parentID = $n['currentID'];
        $newState =   $n['currentState'];
        global $O;

        switch ($direction) {
            case 'up':  if ($ninePosition > 3) {
                $tmp = $newState[$ninePosition];
                $newState[$ninePosition] = $newState[$ninePosition - 3];
                $newState[$ninePosition - 3] = $tmp;

                $newNinePosition = $ninePosition - 3 ;
                global $O;
                
                $newStatePathCost = $O[$parentID]['pathCost'] + 1;
                $newStateMahattan = calculateMahattan($newState);
                

  //              var_dump(array_search($newState, array_column($O, 'currentState' ), true));

                $searchPos = array_search($newState, array_column($O, 'currentState' ), true);

                if ( $searchPos === false ) {
                    global $O;

                    array_push($O, ['currentState' => $newState, 
                                    'ninePos' => $newNinePosition, 
                                    'Mahattan' => $newStateMahattan,
                                    'pathCost' => $newStatePathCost,
                                    'parentID' => $parentID,
                                    'nodeStatus' => 'inQueue'] );

                } else { 
                    if ( $newStateMahattan + $newStatePathCost < $O[$searchPos]['Mahattan'] + $O[$searchPos]['pathCost']  ){
                        global $O;

                        $O[$searchPos]['Mahattan'] = $newStateMahattan;
                        $O[$searchPos]['pathCost'] = $newStatePathCost;
                        $O[$searchPos]['parentID'] = $parentID;
                        $O[$searchPos]['nodeStatus'] = 'inQueue';
 
                    }
                }
            }
            break;

            case 'down': if ($ninePosition < 7){
                $tmp = $newState[$ninePosition];
                $newState[$ninePosition] = $newState[$ninePosition + 3];
                $newState[$ninePosition + 3] = $tmp;
                $newNinePosition = $ninePosition + 3 ;
                global $O; global $mahattanArr;

                $newStatePathCost = $O[$parentID]['pathCost'] + 1;
                $newStateMahattan = calculateMahattan($newState);
                

  //              var_dump(array_search($newState, array_column($O, 'currentState' ), true));

                $searchPos = array_search($newState, array_column($O, 'currentState' ), true);

                if ( $searchPos === false ) {
                    array_push($O, ['currentState' => $newState, 
                                    'ninePos' => $newNinePosition, 
                                    'Mahattan' => $newStateMahattan,
                                    'pathCost' => $newStatePathCost,
                                    'parentID' => $parentID,
                                    'nodeStatus' => 'inQueue'] );
       
                } else { 
                    if ( $newStateMahattan + $newStatePathCost < $O[$searchPos]['Mahattan'] + $O[$searchPos]['pathCost']  ){
                        global $O;

                        $O[$searchPos]['Mahattan'] = $newStateMahattan;
                        $O[$searchPos]['pathCost'] = $newStatePathCost;
                        $O[$searchPos]['parentID'] = $parentID;

                        $O[$searchPos]['nodeStatus'] = 'inQueue';
                    
    
                    }
                }
            }
            break;

            case 'left': if ($ninePosition % 3 != 1){
                $tmp = $newState[$ninePosition];
                $newState[$ninePosition] = $newState[$ninePosition - 1];
                $newState[$ninePosition - 1] = $tmp;
                
                $newNinePosition = $ninePosition - 1 ;
                global $O; global $mahattanArr;
                
                $newStatePathCost = $O[$parentID]['pathCost'] + 1;
                $newStateMahattan = calculateMahattan($newState);
                

   //             var_dump(array_search($newState, array_column($O, 'currentState' ), true));

                $searchPos = array_search($newState, array_column($O, 'currentState' ), true);

                if ( $searchPos === false ) {
                    array_push($O, ['currentState' => $newState, 
                                    'ninePos' => $newNinePosition, 
                                    'Mahattan' => $newStateMahattan,
                                    'pathCost' => $newStatePathCost,
                                    'parentID' => $parentID,
                                    'nodeStatus' => 'inQueue'] );
          
                } else { 
                    if ( $newStateMahattan + $newStatePathCost < $O[$searchPos]['Mahattan'] + $O[$searchPos]['pathCost']  ){
                        global $O;
                        $O[$searchPos]['Mahattan'] = $newStateMahattan;
                        $O[$searchPos]['pathCost'] = $newStatePathCost;
                        $O[$searchPos]['parentID'] = $parentID;

                        $O[$searchPos]['nodeStatus'] = 'inQueue';
                    
          
                    }
                }
            }
            break;

            case 'right': if ($ninePosition % 3 != 0){
                $tmp = $newState[$ninePosition];
                $newState[$ninePosition] = $newState[$ninePosition + 1];
                $newState[$ninePosition + 1] = $tmp;
                
                $newNinePosition = $ninePosition +1 ;
                global $O; global $mahattanArr;
                
                $newStatePathCost = $O[$parentID]['pathCost'] + 1;
                $newStateMahattan = calculateMahattan($newState);
                

     //           var_dump(array_search($newState, array_column($O, 'currentState' ), true));

                $searchPos = array_search($newState, array_column($O, 'currentState' ), true);

                if ( $searchPos === false ) {
                    array_push($O, ['currentState' => $newState, 
                                    'ninePos' => $newNinePosition, 
                                    'Mahattan' => $newStateMahattan,
                                    'pathCost' => $newStatePathCost,
                                    'parentID' => $parentID,
                                    'nodeStatus' => 'inQueue'] );
    
                } else { 
                    if ( $newStateMahattan + $newStatePathCost < $O[$searchPos]['Mahattan'] + $O[$searchPos]['pathCost']  ){
                        global $O;
                        $O[$searchPos]['Mahattan'] = $newStateMahattan;
                        $O[$searchPos]['pathCost'] = $newStatePathCost;
                        $O[$searchPos]['parentID'] = $parentID;

                        $O[$searchPos]['nodeStatus'] = 'inQueue';
   
                    }
                }
            }
            break;
        }
        
    }

    function calculateMahattan($state) {
        global $p;
        $m_distance = 0;
        foreach ($state AS $place => $number) {
           $thisMahattan = abs( $p[$place]['x'] - $p[$number]['x'] ) + abs( $p[$place]['y'] - $p[$number]['y'] ) ;
           $m_distance += $thisMahattan;
        }
        return $m_distance;
    }
    
    function nodeHasMinMahattanDistance () {
        global $O;
        $minDistance = 99;
        $minKey = 0;
        foreach( $O as $key => $aNode ) {
            if ( $aNode['nodeStatus'] == 'inQueue' ) {
                if ($aNode['Mahattan'] + $aNode['pathCost'] < $minDistance) {
                    $minDistance = $aNode['Mahattan'] + $aNode['pathCost'];
                //    echo $minKey . "<br>";
                    $minKey = $key;
                }
            }
        }

        $O[$minKey]['nodeStatus'] = 'offQueue' ;
        $O[$minKey]['currentID'] = $minKey;
        //echo "\n Chọn :" . $minKey ;
        return $O [$minKey];
    }

    function trace ($n) {
        global $O;
        $currentID = $n['currentID'];
        $solution = [];
        $solution_PathCost = 0;
        do {
            array_push($solution, $O[$currentID]['currentState']);
            $solution_PathCost ++;
            $currentID =  $O[$currentID]['parentID'];

        } while ( $O[$currentID]['currentID'] !== 0 );
        echo json_encode($solution);
    }
    // $result = json_encode($start);
    // echo $result;
?>