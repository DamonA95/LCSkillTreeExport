<?php

class CExportLod extends CWriteType {

    var $fp;
    var $CheckSumGlobal;

    Private Function Create( $fileName ) {
        $this->fp = fopen( $fileName, 'wb' );

        if ( !$this->fp ) {
            return false;
        }
        return true;
    }

    Public Function ExportSkillTree() {
        if ( $this->Create( $this->GetExportPath( 1 ) . "skill_tree.bin" ) ) {
            $this->Msg( "File was created!", "success" );
        } else {
            $this->Msg( "[Error] File can't created", "error" );
        }

        for ( $i = 0; $i < 9; $i++ ) {
            // First Loop for 9 Character Classes
            for ( $j = 0; $j < 3; $j++ ) {
                // Second Loop for 3 Sub Classes
                // 
                // Create the Row and loop it
                // in each row you have 8 items so lets make a calculate
                // 
                // we round all up with ceil like 3.1 to 4
                $Count = $this->CountRow( "SELECT * FROM t_skill WHERE a_job = $i and a_job2 = $j ORDER BY a_index", "t_skill" );
                $RowCount = ceil( $Count / 8 );

                // must set a minimum of 1 otherwise it will bug
                if ( $RowCount == 0 )
                    $RowCount = 1;
                $this->WriteInt( $RowCount );

                // Here start the loop for the rows from every job            
                for ( $l = 0; $l < $RowCount; $l++ ) {
                    // Now let's go with the 8 cols in each row              
                    //
                    // Offset to select every the right 8 
                    $Offset = $l * 8;
                    // limit 8 because just 8 cols                 
                    $query = "SELECT * FROM t_skill WHERE a_job = ? and a_job2 = ? ORDER BY a_index LIMIT 8 OFFSET ? ";
                    $stmt = $this->mysqliLC->prepare( $query );
                    if ( $stmt = $this->mysqliLC->prepare( $query ) ) {
                        $stmt->bind_param("iii", $i, $j, $Offset);
                        $stmt->execute();
                        $res = $stmt->get_result();
                    } else {
                        $this->Msg( $this->mysqliLC->error, "errorquery" );
                    }

                    // can run max 8 times for each row
                    // so we run with the limit and offset between 0 and 8 times                 
                    $z = 0;
                    while ( $row = $res->fetch_assoc() ) {
                        $SkillID = $row[ 'a_index' ];
                        $this->WriteInt( $SkillID );                                       
                        $z++;
                    }
                    // if the limit and offset just have example 5 times we use the last 3 times with a 0 
                    for (; $z < 8; $z++ ) {
                        $this->WriteInt( 0 );
                    }
                }
            }
        }
    }

}
