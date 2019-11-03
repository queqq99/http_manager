<?php
namespace queqq99\http_manager\client;
use queqq99\http_manager\client\lib\lib1;
class http_client
{
    //cURLデフォルトオプションリスト
    private $curl_opt_list = [
        //CURLOPT_CUSTOMREQUEST => 'POST',
        //CURLOPT_AUTOREFERER => true,
        CURLOPT_FOLLOWLOCATION => true, #Locationをたどる
        CURLOPT_MAXREDIRS => 5, #Locationをたどる最大数
        CURLOPT_TIMEOUT => 60, #タイムアウト秒数
        CURLOPT_TIMEOUT_MS => 1000, #タイムアウトミリ秒
        CURLOPT_RETURNTRANSFER => true, #リクエスト実行の戻り値を取得する
        //CURLOPT_USERAGENT => '',
        CURLOPT_HEADER => true, #ヘッダーを出力
        //CURLOPT_HTTPHEADER => $header_list,
        //CURLOPT_COOKIEJAR => '',
        //CURLOPT_COOKIEFILE => '',
        //CURLOPT_POSTFIELDS => http_build_query($post_list),
        //CURLOPT_FILE => $resource, #転送内容を出力するファイルハンドル。デフォルトはSTDOUT
        //CURLOPT_WRITEHEADER => $resource, #転送ヘッダーを出力するファイルハンドラ
    ];

    //ヘッダーリスト
    private $header_list = [];
    //コンテンツリスト
    private $content_list = [];
    //レスポンス値
    private $response_value = '';

    //POST用ヘッダーリスト
    private $post_header_list = [
        //'Content-Type: application/x-www-form-urlencoded',
        //'Content-Length: 0',
    ];

    function __construct()
	{
	}

	/*
	 * GETリクエスト実行
	 *
	 * @param string $req_url リクエストURL
	 * @return boolean $result 処理結果
	 */
	function requestHttpGet(string $req_url = '')
	{
	    $result = true;

	    //ヘッダー設定
	    if(!empty($this->header_list))
	    {
	        $this->curl_opt_list[CURLOPT_HTTPHEADER] = $this->header_list;
	    }

	    $curl_handle = curl_init();
	    //オプション指定
	    curl_setopt_array($curl_handle, $this->curl_opt_list);
	    //リクエスト実行
	    $this->response_value = curl_exec($curl_handle);
	    curl_close($curl_handle);

	    if($this->response_value === false)
	    {
	        $result = false;
	    }

	    return $result;
	}

	/*
	 * POSTリクエスト実行
	 *
	 * @param string $req_url リクエストURL
	 * @return boolean $result 処理結果
	 */
	function requestHttpPost(string $req_url = '')
	{
        $result = true;

        //コンテンツ設定
        if(!empty($this->content_list))
        {
            $post_query_string = http_build_query($this->content_list, '', '&');
            $this->curl_opt_list[CURLOPT_POSTFIELDS] = $post_query_string;
            //ヘッダーのContent-Lengthに文字数設定
            $this->header_list[] = 'Content-Length: '.strlen($post_query_string);
        }
        //ヘッダー設定
        if(!empty($this->header_list))
        {
            $this->curl_opt_list[CURLOPT_HTTPHEADER] = $this->header_list;
        }
        //cURLオプション設定
        $this->curl_opt_list[CURLOPT_CUSTOMREQUEST] = 'POST';

        $curl_handle = curl_init();
        //オプション指定
        curl_setopt_array($curl_handle, $this->curl_opt_list);
        //リクエスト実行
        $this->response_value = curl_exec($curl_handle);
        curl_close($curl_handle);

        if($this->response_value === false)
        {
            $result = false;
        }

        return $result;
	}

    /*
     * cURLオプションリストをセット
     *
     * @param array $opt_list cURLオプションリスト
     * @param boolean $empty_flg プロパティのオプションリストをカラにするかの判定フラグ
     * @return boolean $result 処理結果
     */
    function setOptionList(Array $opt_list = [], $empty_flg = false)
    {
        $result = true;

        //カラ設定の場合
        if($empty_flg)
        {
            $this->curl_opt_list = [];
        }
        //ヘッダー設定
        if(!empty($opt_list))
        {
            $this->curl_opt_list = array_merge($this->curl_opt_list, $opt_list);
        }

        return true;
    }

    /*
     * HTTPリクエストヘッダーをセット
     *
     * @param array $header_list ヘッダーリスト
     * @param boolean $empty_flg プロパティのヘッダーリストをカラにするかの判定フラグ
     * @return boolean $result 処理結果
     */
    function setHeaderList(Array $header_list = [], $empty_flg = false)
    {
        $result = true;

        //カラ設定の場合
        if($empty_flg)
        {
            $this->header_list = [];
        }
        //ヘッダー設定
        if(!empty($header_list))
        {
            $this->header_list = array_merge($this->header_list, $header_list);
        }

        return true;
    }

    /*
     * HTTPリクエストコンテンツをセット
     *
     * @param array $content_list コンテンツリスト
     * @param boolean $empty_flg プロパティのコンテンツリストをカラにするかの判定フラグ
     * @return boolean $result 処理結果
     */
    function setContentList(Array $content_list = [], $empty_flg = false)
    {
        $result = true;

        //カラ設定の場合
        if($empty_flg)
        {
            $this->content_list = [];
        }
        //ヘッダー設定
        if(!empty($content_list))
        {
            $this->content_list = array_merge($this->content_list, $content_list);
        }

        return true;
    }

    /*
     * レスポンス値取得
     *
     * @param
     * @return string $response_value レスポンス値
     */
    function getResponseValue()
    {
        return $this->response_value;
    }
}


