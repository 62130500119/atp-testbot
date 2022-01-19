<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MemberRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use PhpParser\Node\Expr\FuncCall;
use App\Models\Member;

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
                $text = $event['message']['text'];
                $messages['replyToken'] = $replyToken;
                if($text == 'ตรวจสอบข้อมูล'){
                    $messages['messages'][] = $this->getFormatTextMessage("ไม่มีให้ตรวจสอบหรอก อิอิ");
                    $messages['messages'][] = $this->getFormatTextMessage("บัยยย");
                }else{
                    $messages['messages'][] = $this->getFormatTextMessage("ทดสอบอยู่ ไม่ว่าง");
                }
            }
        }
        $encodedMessage = json_encode($messages);

        $LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
        $LINEDatas['token'] = "tDPaJd+bW7UKPKF5zqRNze0Oh17zytPFmQmtGkJsSMY2WT+HaUpS1o0np4Fd3x+WxsOSQ5J3j1cXI6A+yN+8a5zr8onFXU7ozOxxjX4VUds70mOAfI74sjOlxFXXBe2+wQy72HqPAQLNrwBKIvD/HwdB04t89/1O/w1cDnyilFU=";

        $this->replyMessage($encodedMessage,$LINEDatas);

        /*Return HTTP Request 200*/
        return http_response_code(200);
    }

    public function getFormatTextMessage($text)
    {
        $datas = [];
        $datas['type'] = 'text';
        $datas['text'] = $text;

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
}
