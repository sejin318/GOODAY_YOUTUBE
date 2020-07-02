/*
 * keditor.js
 * Copyright Kothing
 * MIT license.
 */
'use strict';

(function (global, factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        module.exports = global.document ?
            factory(global, true) :
            function (w) {
                if (!w.document) {
                    throw new Error('KEDITOR_LANG a window with a document');
                }
                return factory(w);
            };
    } else {
        factory(global);
    }
}(typeof window !== 'undefined' ? window : this, function (window, noGlobal) {
    const lang = {
        toolbar: {
            default: '기본값',
            save: '저장',
            font: '글꼴',
            formats: '형식',
            fontSize: '크기',
            bold: '굵게',
            underline: '밑줄',
            italic: '기울임',
            strike: '취소선',
            subscript: '아랫첨자',
            superscript: '윗첨자',
            removeFormat: '형식 삭제',
            fontColor: '글꼴색',
            hiliteColor: '배경색',
            indent: '들여쓰기',
            outdent: '내어쓰기',
            align: '정렬',
            alignLeft: '왼쪽 정렬',
            alignRight: '오른쪽 정렬',
            alignCenter: '가운데 정렬',
            alignJustify: '양쪽 맞춤',
            list: '목록',
            orderList: '번호가 있는 목록',
            unorderList: '번호가 없는 목록',
            horizontalRule: '수평선',
            hr_solid: '직선',
            hr_dotted: '점이 찍힌 선',
            hr_dashed: '점선',
            table: '표',
            link: '링크',
            image: '그림',
            video: '영상',
            fullScreen: '전체 화면',
            showBlocks: '영역 보이기',
            codeView: 'HTML 태그 보기',
            undo: '이전',
            redo: '다음',
            preview: '미리보기',
            print: '인쇄',
            tag_p: '단락',
            tag_div: '일반',
            tag_h: '머릿말',
            tag_blockquote: '인용문',
            tag_pre: '코드',
            template: '템플릿'
        },
        dialogBox: {
            linkBox: {
                title: '링크 삽입하기',
                url: '주소',
                text: '표시 할 텍스트',
                newWindowCheck: '새창에서 열기'
            },
            imageBox: {
                title: '이미지',
                file: '파일을 선택하세요',
                url: '주소',
                altText: '설명'
            },
            videoBox: {
                title: '비디오 삽입',
                url: '비디오 주소나 Youtube 주소를 삽입하세요'
            },
            caption: '캡션(설명) 넣기',
            close: '닫기',
            submitButton: '확인',
            revertButton: '취소',
            proportion: '비율 유지',
            width: '넓이',
            height: '높이',
            basic: '기본',
            left: '왼쪽',
            right: '오른쪽',
            center: '가운데'
        },
        controller: {
            edit: '편집',
            remove: '삭제',
            insertRowAbove: '행 위 삽입',
            insertRowBelow: '행 아래 삽입',
            deleteRow: '행 삭제',
            insertColumnBefore: '이전 열 삽입',
            insertColumnAfter: '이후 열 삽입',
            deleteColumn: '열 삭제',
            resize100: '크기 100%',
            resize75: '크기 75%',
            resize50: '크기 50%',
            resize25: '크기 25%',
            mirrorHorizontal: '수평(보안문제로 지원되지 않습니다)',
            mirrorVertical: '수직(보안문제로 지원되지 않습니다)',
            rotateLeft: '왼쪽 회전(보안문제로 지원되지 않습니다)',
            rotateRight: '오른쪽 회전(보안문제로 지원되지 않습니다)',
            maxSize: '최대 크기',
            minSize: '최소 크기',
            tableHeader: '테이블 헤더',
            mergeCells: '셀 병합',
            splitCells: '셀 나누기',
            HorizontalSplit: '수평 분할',
            VerticalSplit: '수직 분할'
        }
    };

    if (typeof noGlobal === typeof undefined) {
        if (!window.KEDITOR_LANG) {
            window.KEDITOR_LANG = {};
        }

        window.KEDITOR_LANG.ko = lang;
    }

    return lang;
}));