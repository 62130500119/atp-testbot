<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MemberRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use PhpParser\Node\Expr\FuncCall;
use App\Models\Member;
use Illuminate\Http\Request;

/**
 * Class MemberCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MemberCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Member::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/member');
        CRUD::setEntityNameStrings('member', 'members');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('uid');
        CRUD::column('name');
        CRUD::column('tel');
        CRUD::column('email');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(MemberRequest::class);

        // CRUD::field('id');
        CRUD::field('uid');
        CRUD::field('name');
        CRUD::field('tel');
        CRUD::field('email');
        // CRUD::field('created_at');
        // CRUD::field('updated_at');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function linebot(){
        $datas = file_get_contents('php://input');
        $events = json_decode($datas,true);
        $messages = [];
        if(!is_null($events['events'])){
            foreach($events['events'] as $event){
                $replyToken = $event['replyToken'];
                $messages['replyToken'] = $replyToken;
                $uid = $event['source']['userId'];
                if($event['type'] == 'message'){
                    $text = $event['message']['text'];
                    if($text == 'ตรวจสอบข้อมูล'){
                        $user = Member::where('uid',$uid)->first();
                        if(is_null($user)){
                            $messages['messages'][] = $this->getFormatTextMessage("ยังไม่ได้ลงทะเบียนนะ กดเมนูขวาสุดเลย");
                        }else{
                            $messages['messages'][] = $this->getFormatTextMessage("ชื่อ : " . $user->name . "\nอีเมลล์ : " . $user->email . "\nเบอร์ : " . $user->tel);
                        }

                    }elseif($text == 'อยากเลี้ยงสัตว์' || $text == 'สัตว์เลี้ยง'){
                        $animals = ['หมา','แมว','หมี','นก','จระเข้'];
                        $messages['messages'][] = $this->getPostbackQR("ตัวอะไร",5,'Animal',$animals);
                    }else{
                        $messages['messages'][] = $this->getFormatTextMessage("ทดสอบอยู่ ไม่ว่าง");
                    }
                }elseif($event['type'] == 'postback'){
                    $data = $event['postback']['data'];
                    switch($data){
                        case preg_match('/Animal\=.*/', $data) ? $data : !$data:
                            $messages['messages'][] = $this->getFormatTextMessage("อยากเลี้ยง" . substr($data,7) . "หรอ อืม ถามไปงั้นแหละ ไม่ได้อยากรู้ ;)");
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        $encodedMessage = json_encode($messages);

        $LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
        $LINEDatas['token'] = "tDPaJd+bW7UKPKF5zqRNze0Oh17zytPFmQmtGkJsSMY2WT+HaUpS1o0np4Fd3x+WxsOSQ5J3j1cXI6A+yN+8a5zr8onFXU7ozOxxjX4VUds70mOAfI74sjOlxFXXBe2+wQy72HqPAQLNrwBKIvD/HwdB04t89/1O/w1cDnyilFU=";

        $this->replyMessage($encodedMessage,$LINEDatas);

        return http_response_code(200);
    }

    public function getFormatTextMessage($text)
    {
        $datas = [];
        $datas['type'] = 'text';
        $datas['text'] = $text;

        return $datas;
    }

    public function getPostbackQR($text,$num,$k,$items)
    {
        $datas = [];
        $datas['type'] = 'text';
        $datas['text'] = $text;
        for($i=0; $i<$num; $i++){
            $datas['quickReply']['items'][$i]['type'] = 'action';
            $datas['quickReply']['items'][$i]['action']['type'] = 'postback';
            $datas['quickReply']['items'][$i]['action']['label'] = $items[$i];
            $datas['quickReply']['items'][$i]['action']['data'] = $k . "=" . $items[$i];
        };


        return $datas;
    }

    public function replyMessage($encodeJson,$datas)
    {
        $datasReturn = [];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $datas['url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $encodeJson,
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer ".$datas['token'],
            "cache-control: no-cache",
            "content-type: application/json; charset=UTF-8",
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $datasReturn['result'] = 'E';
            $datasReturn['message'] = $err;
        } else {
            if($response == "{}"){
            $datasReturn['result'] = 'S';
            $datasReturn['message'] = 'Success';
            }else{
            $datasReturn['result'] = 'E';
            $datasReturn['message'] = $response;
            }
        }

        return $datasReturn;
    }

    public function regis(Request $request){
        if(Member::where('uid',$request->userid)->exists()){
            $member = Member::where('uid',$request->userid)->first();
        }else{
            $member = new Member;
            $member->uid = $request->userid;
        }

        $name = $request->name;
        $tel = $request->tel;
        $email = $request->email;

        $member->name = $name;
        $member->tel = $tel;
        $member->email = $email;
        $member->save();
        return view('liffinfo',compact('name','tel','email'));
    }

    public function getinfo(Request $request){
        $member = Member::where('uid',$request->userid)->first();
        return $member->makeHidden('id','uid');
    }
}
