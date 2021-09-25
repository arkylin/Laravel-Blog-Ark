<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vditor/dist/index.css" />
<script src="https://cdn.jsdelivr.net/npm/vditor/dist/index.min.js"></script>
<div id="vditor" name="description" ></div>
<script>
    let toolbar
    toolbar = [
        'emoji',
        'headings',
        'bold',
        'italic',
        'strike',
        'link',
        '|',
        'list',
        'ordered-list',
        'check',
        'outdent',
        'indent',
        '|',
        'quote',
        'line',
        'code',
        'inline-code',
        'insert-before',
        'insert-after',
        '|',
        // 'upload',
        // 'record',
        'table',
        '|',
        'undo',
        'redo',
        '|',
        'edit-mode',
        'content-theme',
        'code-theme',
        'export',
        {
        name: 'more',
        toolbar: [
            'fullscreen',
            'both',
            'preview',
            // 'info',
            // 'help',
        ],
        }]

    window.vditor = new Vditor('vditor', {
    // _lutePath: `http://192.168.0.107:9090/lute.min.js?${new Date().getTime()}`,
    //   _lutePath: 'src/js/lute/lute.min.js',
    toolbar,
    mode: 'wysiwyg',
    height: window.innerHeight + 100,
    debugger: true,
    typewriterMode: true,
    placeholder: 'Hello, Vditor!',
    preview: {
        markdown: {
        toc: true,
        mark: true,
        footnotes: true,
        autoSpace: true,
        },
        math: {
        engine: 'KaTeX',
        },
    },
    toolbarConfig: {
        pin: true,
    },
    // upload: {
    //     accept: "image/*",
    //     url: 'https://blog.xyz.blue/admin/upload',
    //     linkToImgUrl: 'https://blog.xyz.blue/admin/upload',
    //     fieldName: 'source',
    //     success(editor, msg){
    //         let content = window.vditor.getHTML();
    //         // content += "<img src='"+  +"'>";
    //         // console.log(editor);
    //         // console.log(msg);
    //         // _this.contentEditor.setValue(content)
    //         window.vditor.insertValue(msg);  // 设置值回显  这种方式 删除内容等分块展示明显，方便操作
    //     },
    // },
    counter: {
        enable: true,
        type: 'text',
    },
    hint: {
        emojiPath: 'https://cdn.jsdelivr.net/npm/vditor@1.8.3/dist/images/emoji',
        emojiTail: '<a href="https://ld246.com/settings/function" target="_blank">设置常用表情</a>',
        emoji: {
        'sd': '💔',
        'j': 'https://unpkg.com/vditor@1.3.1/dist/images/emoji/j.png',
        },
        parse: false,
        extend: [
        {
            key: '@',
            hint: (key) => {
            console.log(key)
            if ('vanessa'.indexOf(key.toLocaleLowerCase()) > -1) {
                return [
                {
                    value: '@Vanessa',
                    html: '<img src="https://avatars0.githubusercontent.com/u/970828?s=60&v=4"/> Vanessa',
                }]
            }
            return []
            },
        },
        {
            key: '#',
            hint: (key) => {
            console.log(key)
            if ('vditor'.indexOf(key.toLocaleLowerCase()) > -1) {
                return [
                {
                    value: '#Vditor',
                    html: '<span style="color: #999;">#Vditor</span> ♏ 一款浏览器端的 Markdown 编辑器，支持所见即所得（富文本）、即时渲染（类似 Typora）和分屏预览模式。',
                }]
            }
            return []
            },
        }],
    },

    @if ( $ifnew != 'y' )
        after () {
            fetch('<?php echo url('posts/api/id') ?>/{{ $post_id }}').
            then(response => response.json()).
            then(content => content['content']).
            then(content => vditor.setValue(content))
        },
    @else
        after () {
            vditor.setValue('')
        },
    @endif

    tab: '\t',
    //   upload: {
    //     accept: 'image/*,.mp3, .wav, .rar',
    //     token: 'test',
    //     url: '/api/upload/editor',
    //     linkToImgUrl: '/api/upload/fetch',
    //     filename (name) {
    //       return name.replace(/[^(a-zA-Z0-9\u4e00-\u9fa5\.)]/g, '').
    //         replace(/[\?\\/:|<>\*\[\]\(\)\$%\{\}@~]/g, '').
    //         replace('/\\s/g', '')
    //     },
    //   },
    })
</script>

<div class="container">
<!-- 引入在线资源 -->
<script src="https://gosspublic.alicdn.com/aliyun-oss-sdk-6.8.0.min.js"></script>
<script>
const client = new OSS({
    // yourRegion填写Bucket所在地域。以华东1（杭州）为例，Region填写为oss-cn-hangzhou。
    region: 'oss-cn-shanghai',
    // 从STS服务获取的临时访问密钥（AccessKey ID和AccessKey Secret）。
    accessKeyId: 'LTAI5tRp6VTHWQMJWFdUbZEy',
    accessKeySecret: 'TBhIKJK9i54rXM1651QySozdmpK1vg',
    // 填写Bucket名称。
    bucket: 'assets-xyz-blue'
});
</script>              
<a href="javascript:void(0)" onclick="uploadPhoto()">选择图片</a>
<input type="file" id="photoFile" style="display: none;" onchange="upload()">
<script>
    function uploadPhoto() {
        $("#photoFile").click();
    }

    /**
     * 上传图片
     */
    function upload() {
        if ($("#photoFile").val() == '') {
            return;
        }
        // var CTime = Math.round(new Date());
        // var formData = new FormData();
        // formData.append('photo', document.getElementById('photoFile').files[0]);
        const data = document.getElementById('photoFile').files[0];
        // var FileName = document.getElementById('photoFile').files[0].name
        async function put () {
            try {
                // object表示上传到OSS的文件名称。
                // file表示浏览器中需要上传的文件，支持HTML5 file和Blob类型。
                var now = new Date();
                month = now.getMonth();
                month = month + 1;
                if (month < 10) month = "0" + month;
                var filename = 'attachments' + '/' + now.getFullYear() + '/' +  month + '/' + now.getTime() + '.' + data.name.split(".")[1];
                const r1 = await client.put(filename, data);
                var link = "<?php if (env('ASSETS_URL') !== '') { echo env('ASSETS_URL'); } ?>" + '/' + filename;
                content = "<img src='"+ link +"' alt=" + data.name +">";
                window.vditor.insertValue(content);
                console.log('put success: %j', r1);
            } catch (e) {
                console.error('error: %j', e);
            }
        }
        put();
        // formData.append('time', CTime);
        // $.ajax({
        //     url:"<?php echo env('APP_URL') ?>/admin/upload",
        //     type:"post",
        //     async: false,
        //     data: formData,
        //     contentType: false,
        //     processData: false,
        //     success: function(data) {
        //         if (data !== '') {
        //             content = "<img src='"+ data +"' alt=" + FileName +">";
        //             window.vditor.insertValue(content);
        //         }
        //     },
        //     error:function(data) {
        //         alert("上传失败")
        //     }
        // });
        // let content = this.vditor.getValue();
        // content = "<img src='/storage/"+ CTime +".png'>";
        // this.vditor.insertValue(content);
    }
</script>
</div>