<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lexington;

class LexingtonController extends Controller
{
    public function index(){
        return view('admin.form_lexington');
    }

    public function destroy($id){
        $user = Lexington::find($id);
        $user->delete();
        return redirect('/admin/scoreLexington')->with('success','evaluation deleted');
    }
    public function store(Request $request) {
        $aftha = new Lexington();
    
        $request->validate([
          'Q1'=>'required',
          'Q2'=>'required',
          'Q3'=>'required',
          'Q4'=>'required',
          'Q5'=>'required',
          'Q6'=>'required',
          'Q7'=>'required',
          'Q8'=>'required',
          'Q9'=>'required',
          'Q10'=>'required',
          'Q11'=>'required',
          'Q12'=>'required',
          'Q13'=>'required',
          'Q14'=>'required',
          'Q15'=>'required',
          'Q16'=>'required',
         
          'C1'=>'max:189',
          'C2'=>'max:189',
          'C3'=>'max:189',
          'C4'=>'max:189',
          'C5'=>'max:189',
          'C6'=>'max:189',
          'C7'=>'max:189',
          'C8'=>'max:189',
          'C9'=>'max:189',
          'C10'=>'max:189',
          'C11'=>'max:189',
          'C12'=>'max:189',
          'C13'=>'max:189',
          'C14'=>'max:189',
          'C15'=>'max:189',
          'C16'=>'max:189',
    
          'finalScore'=>'numeric',
          'finalComment'=>'required',
        ]);
    
        $aftha->Q1 = $request->Q1;
        $aftha->Q2 = $request->Q2;
        $aftha->Q3 = $request->Q3;
        $aftha->Q4 = $request->Q4;
        $aftha->Q5 = $request->Q5;
        $aftha->Q6 = $request->Q6;
        $aftha->Q7 = $request->Q7;
        $aftha->Q8 = $request->Q8;
        $aftha->Q9 = $request->Q9;
        $aftha->Q10 = $request->Q10;
        $aftha->Q11 = $request->Q11;
        $aftha->Q12 = $request->Q12;
        $aftha->Q13 = $request->Q13;
        $aftha->Q14 = $request->Q14;
        $aftha->Q15 = $request->Q15;
        $aftha->Q16 = $request->Q16;
   
    
        $aftha->C1 = $request->C1;
        $aftha->C2 = $request->C2;
        $aftha->C3 = $request->C3;
        $aftha->C4 = $request->C4;
        $aftha->C5 = $request->C5;
        $aftha->C6 = $request->C6;
        $aftha->C7 = $request->C7;
        $aftha->C8 = $request->C8;
        $aftha->C9 = $request->C9;
        $aftha->C10 = $request->C10;
        $aftha->C11 = $request->C11;
        $aftha->C12 = $request->C12;
        $aftha->C13 = $request->C13;
        $aftha->C14 = $request->C14;
        $aftha->C15 = $request->C15;
        $aftha->C16 = $request->C16;
       
        $aftha->score= $request->finalScore;
        $aftha->QA_id = $request->QA_id;
        $aftha->user_id= $request->agentID;
        $aftha->audio = $request->audio;
        $aftha->final_comment = $request->finalComment;
        $aftha->phone = $request->phone;
        if($aftha->save()){
          return redirect('admin/lexington')->with('success','Qualify stored successfully');
        }else{
          return redirect('admin/lexington')->withInput($request->only('C1','C2','C3','C4','C5','C6','C7','C8','C9','C10','C11','C12','finalComment'));
        }
      }

      public function getAllScores(){
        $this->user = Lexington::select(
          array('lexingtons.id as DT_RowId','users_table.name as name','quality_table.name as qaname','lexingtons.score as score',
                        'lexingtons.audio as audio','lexingtons.created_at as date' ,'lexingtons.phone as phone', 'lexingtons.acknowledge as acknowledge')
        )
        ->leftJoin('users as users_table','users_table.id','=','lexingtons.user_id')
        ->leftJoin('users as quality_table','quality_table.id','=','lexingtons.QA_id')
        ->orderBy('lexingtons.created_at','desc')
        ->take(800)
        ->get();
    
        $users = $this->user->toArray();
        $data = array();
        
        foreach ($users as $key => $user){
        // echo $ids[0]['name'];
        // $users[$key]['sup']= $ids[0]['name'];
    
          $users[$key]['DT_RowAttr'] = array(
            'title'	=>	'Manage score of: '.$user['name'],
            'data-toggle'  => "popover",
            'data-trigger' => "focus",
            'data-content'	=>	"
              <div>
                <a class='btn btn-secondary btn-block' href='javascript:showComments(".$user['DT_RowId'].")'>View comments</a>
                <form style='margin-top: 5px;' action='".url("admin/scoreLexington/".$user['DT_RowId'])."' method='post'>".csrf_field().method_field('DELETE')."
                  <button value='submit' class='btn btn-danger btn-block'>
                    <span class='glyphicon glyphicon-ban-circle pull-left'></span>Delete evaluation
                  </button>
                </form>
              </div>"
          );
        }
          
        $data['data'] = $users;
        //  <form style='margin-top: 5px;'
        //  action='".url("/events/deleteInscription/".$user['DT_RowId'])."'
        //  method='post'>
        //  ".csrf_field().
        //  method_field('DELETE')."
        //  <a href='".url("/events/deleteInscription/".$user['DT_RowId'])."'
        //  class='btn btn-danger btn-block'><span class='glyphicon glyphicon-ban-circle pull-left'>
        //  </span>Delete inscription</a>
        //  </form>
        // Set dates on session
        return json_encode($data, JSON_PRETTY_PRINT);
      }

      public function getComments($id){
        $comments = Lexington::select(array('C1','C2','C3','C4','C5','C6','C7','C8','C9','C10','C11','C12','C13','C14','C15','C16','final_comment','phone','audio','Q1','Q2','Q3','Q4','Q5','Q6','Q7','Q8','Q9','Q10','Q11','Q12','Q13','Q14','Q15','Q16'))
        ->where('id',$id)->get();
    
        foreach ($comments as $key => $value) {
          echo $value['phone'].'=>';
          echo $value['audio'].'=>';
            
          $c = 1;
          do { 
            echo $value['C'.$c].'=>';
            $c++;
          } while (
            $c <= 16
          );
    
          echo $value['final_comment'].'=>';
    
          $a=1;
          do {
            echo $value['Q'.$a].'=>';
            $a++;
          } while (
            $a <= 16
          );
        }
      }
}
