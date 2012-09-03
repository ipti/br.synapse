<?php

class RenderController extends Controller {

    public $layout = 'render';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'json'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionJson() {
        if (@$_POST['op'] == 'start') {
            $json = array();
            $disciplines = ActDiscipline::model()->findAll();
            $classes = Userclass::model()->findAll();
            $a = -1;
            foreach ($disciplines as $discipline) {
                $a++;
                $json['disciplines'][$a] = $discipline->attributes;
                $scripts = ActScript::model()->findAllByAttributes(array('disciplineID' => $discipline->ID));
                $rscript = array();
                $b = -1;
                foreach ($scripts as $script) {
                    $b++;
                    $rscript[$b] = $script->attributes;
                    $rscript[$b]['name'] = $script->contentParent->description;
                }
                $json['disciplines'][$a]['scripts'] = @$rscript;
            }
            $aa = -1;
            foreach ($classes as $class) {
                $students = UserUserclass::model()->findAllByAttributes(array('classID' => $class->ID));
                $rstudents = array();
                foreach ($students as $student) {
                    $rstudents[] = $student->user->attributes;
                }
                $aa++;
                $tutors[1]['name'] = 'Fabio Theoto Rocha';
                $tutors[1]['ID'] = 1;
                $json['classes'][$aa] = $class->attributes;
                $json['classes'][$aa]['students'] = @$rstudents;
                $json['classes'][$aa]['tutors'] = @$tutors;
            }
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');
            echo json_encode($json);
            exit;
        }
        $script = ActScript::model()->findByAttributes(array('ID' => $_POST['script']));
        $json = array();
        //lembra de excluir os conteudos exclude e include
        $contents = ActContent::model()->findAllByAttributes(array('contentParent' => $script->contentParentID));
        $x = -1;
        foreach ($contents as $content) {
            $x++;
            $json['contents'][$x] = $content->attributes;
            $type = CommonType::model()->findByAttributes(array('name' => 'goalID'));
            $y = -1;
            foreach ($content->actGoalContents as $goal) {
                $y++;
                $json['contents'][$x]['goals'][$y] = $goal->goal->attributes;
                $json['contents'][$x]['goals'][$y]['discipline'] = $goal->goal->discipline->name;
                $cobjects = CobjectMetadata::model()->findAllByAttributes(array('typeID' => $type->ID, 'value' => $goal->goal->ID));
                $z = -1;
                foreach ($cobjects as $cobject) {
                    //com base no tema filtrar
                    $z++;
                    $json['contents'][$x]['goals'][$y]['cobjects'][$z] = $cobject->cobject->attributes;
                    $json['contents'][$x]['goals'][$y]['cobjects'][$z]['template'] = $cobject->cobject->template->name;
                    $json['contents'][$x]['goals'][$y]['cobjects'][$z]['template_code'] = $cobject->cobject->template->code;
                    $json['contents'][$x]['goals'][$y]['cobjects'][$z]['theme'] = $cobject->cobject->theme->name;
                    
                    $w = -1;
                    foreach ($cobject->cobject->editorScreens as $screen) {
                        $w++;
                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w] = $screen->attributes;
                        $v = -1;
                        foreach ($screen->editorScreenPiecesets as $pieceset) {
                            $v++;
                            $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v] = $pieceset->pieceset->attributes;
                            $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['template'] = $pieceset->template->name;
                            $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['template_code'] = $pieceset->template->code;
                            $a = -1;
                            foreach ($pieceset->pieceset->editorPiecesetPieces as $piece) {
                                $a++;
                                $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a] = $piece->piece->attributes;
                                $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['type'] = $piece->piece->type->name;
                                $b = -1;
                                foreach ($piece->piece->editorPieceElements as $element) {
                                    $b++;
                                    $properties = $events = $gproperties = array();
                                    foreach ($element->editorPieceelementProperties as $property) {
                                        $properties[] = array('name' => $property->property->name, 'value' => $property->value);
                                    }
                                    foreach ($element->editorEvents as $event) {
                                        $events[] = array('name' => $event->type->name, 'event' => $event->event, 'action' => $event->action);
                                    }
                                    foreach ($element->element->editorElementProperties as $gproperty) {
                                        if ($gproperty->property->name == 'libraryID') {
                                            $lib = Library::model()->findByAttributes(array('ID' => $gproperty->value));
                                            foreach ($lib->libraryProperties as $libproperty) {
                                                $gproperties[] = array('name' => $libproperty->property->name, 'value' => $libproperty->value);
                                            };
                                        } else {
                                            $gproperties[] = array('name' => $gproperty->property->name, 'value' => $gproperty->value);
                                        }
                                    }
                                    /*
                                      foreach ($element->element->editorElementAliases as $alias){
                                      $gproperties[] = array('type'=>$alias->type->name,'value'=>$gproperty->value);
                                      } */
                                    $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['code'] = 'EP' . $element->element->ID;
                                    $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['elementProperties'] = $properties;
                                    $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['events'] = $events;
                                    $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['generalProperties'] = $gproperties;
                                    $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['type'] = $element->element->type->name;
                                }
                            }
                        }
                    }
                }
            }
        }
        //print_r($json);
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($json);
        exit;
        //$this->render('index');
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}