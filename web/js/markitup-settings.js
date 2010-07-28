// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
rtMarkdownSettings = {
    nameSpace:          'markdown', // Useful to prevent multi-instances CSS conflict
    previewParserPath:  '~/sets/markdown/preview.php',
    onShiftEnter:       {keepDefault:false, openWith:'\n\n'},
    markupSet: [
        //{name:'First Level Heading', key:"1", placeHolder:'Your title here...', closeWith:function(markItUp) { return miu.markdownTitle(markItUp, '=') } },
        {name:'Second Level Heading', key:"2", placeHolder:'Your title here...', closeWith:function(markItUp) { return miu.markdownTitle(markItUp, '-') } },
        {name:'Heading 3', key:"3", openWith:'### ', placeHolder:'Your title here...' },
        {name:'Heading 4', key:"4", openWith:'#### ', placeHolder:'Your title here...' },
        {name:'Heading 5', key:"5", openWith:'##### ', placeHolder:'Your title here...' },
        {name:'Heading 6', key:"6", openWith:'###### ', placeHolder:'Your title here...' },
        {separator:'---------------' },
        {name:'Bold', key:"B", openWith:'**', closeWith:'**'},
        {name:'Italic', key:"I", openWith:'_', closeWith:'_'},
        {separator:'---------------' },
        {name:'Bulleted List', openWith:'- ' },
        {name:'Numeric List', openWith:function(markItUp) {
            return markItUp.line+'. ';
        }},
        {separator:'---------------' },
//        {name:'Picture', key:"P", replaceWith:'![[![Alternative text]!]]([![Url:!:http://]!] "[![Title]!]")'},
//        {name:'Link', key:"L", openWith:'[', closeWith:']([![Url:!:http://]!] "[![Title]!]")', placeHolder:'Your text to link here...' },
        {
          name:'Internal Link',
          key:"L",
          openWith:'',
          closeWith:'',
          placeHolder:'',
          beforeInsert:function(h) {
            //alert('You selected "'+h.selection+'" ... '+"with "+h.openWith+" and "+h.closeWith+".");
          },
          afterInsert:function(h) {
              $('.' + $(h.textarea).attr('id')).overlay({
                expose: {
                  color: '#000',
                  loadSpeed: 200,
                  opacity: 0.4
                },
                api: true 
              }).load();
          }
        },
        {name:'Gallery', key:"G", openWith:'[gallery]'},
        {name:'Docs', key:"D", openWith:'[docs]'},
        {separator:'---------------' },
        {name:'Separator', openWith:'\n////\n'}
    ]
}

// mIu nameSpace to avoid conflict.
miu = {
    markdownTitle: function(markItUp, string) {
        heading = '';
        n = $.trim(markItUp.selection||markItUp.placeHolder).length;
        for(i = 0; i < n; i++) {
            heading += string;
        }
        return '\n'+heading+'\n';
    }
}