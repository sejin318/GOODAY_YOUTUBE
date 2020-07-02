<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

/****************************************************
 *  상수설정
 ****************************************************/
//편집시 자동백업 1 = 백업, 0 = 사용하지않음
define('AF_BACKUP', 1);

//출력하지 않을 파일 확장자
//ex) png,jpg,gif,sh,json
define('AF_EXCLUDE', '');

//출력하지 않을 디렉토리 , 로 구분, 공백없이 입력
//ex) bower_components,node_modules,vendor
define('AF_EXCLUDE_DIR', '');

#############################################
# 그누보드 기본 폴더는 삭제, 이름변경 금지 처리
#############################################
//삭제금지 디렉토리 - 경로를 구분하지 않습니다. 폴더 이름으로만 체크
define('AF_EXCLUDE_DELETE_DIR', 'www,public_html,adm,bbs,data,extend,img,js,lib,mobile,plugin,skin,theme');
//이름변경 금지 디렉토리 - 경로를 구분하지 않습니다. 폴더이름으로만 체크
define('AF_EXCLUDE_RENAME_DIR', 'www,public_html,adm,bbs,data,extend,img,js,lib,mobile,plugin,skin,theme');


//ascii  파일 목록 - 텍스트파일 확장자를 추가하세요. ,로 구분, 공백없이 입력, 텍스트 파일만 편집이 가능합니다.
//아래 설정파일을 제외한 파일은 Binary로 업로드 됩니다.
define('AF_ASCII', 'txt,csv,sql,xml,js,php,css,scss,htm,html,rss,json,sh,am,asp,bat,cfm,cgi,conf,cpp,dhtml,diz,h,hpp,in,inc,m4,mak,nfs,nsi,pas,patch,pl,po,py,qmail,shtml,sql,tcl,tpl,vbs,xrc');

//ftp 루트 수정, 삭제 - 루트 관리(수정,삭제)는 사용하지 않는게 좋습니다. ftp root 삭제시 사이트가 서버에서 삭제됩니다. 1=사용, 0은 미사용
//ftp 루트 / 에 그누보드가 설치된 경우에만 1로 사용하세요.
define('AF_ROOT_MANAGE', 0);






//암호화
define('AF_SECRET_KEY', 'ASKFTPV1SECRETKEY');
//수정금지, 수정시 자릿수 유지 - 16자리
define('AF_SECRET_IV', 'bcdefg3456789012');
