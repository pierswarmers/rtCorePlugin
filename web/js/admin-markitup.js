// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
rtMarkdownSettings = {
    nameSpace:          'markdown',
    previewParserPath:  '~/sets/markdown/preview.php',
    onShiftEnter:       {keepDefault:false, openWith:'\n\n'},
    markupSet: [
        {name:'Second Level Heading', key:"2", placeHolder:'Your title here...', closeWith:function(markItUp) {return miu.markdownTitle(markItUp, '-')}},
        {name:'Heading 3', key:"3", openWith:'### ', placeHolder:'Your title here...'},
        {name:'Heading 4', key:"4", openWith:'#### ', placeHolder:'Your title here...'},
        {name:'Heading 5', key:"5", openWith:'##### ', placeHolder:'Your title here...'},
        {name:'Heading 6', key:"6", openWith:'###### ', placeHolder:'Your title here...'},
        {separator:'---------------'},
        {name:'Bold', key:"B", openWith:'**', closeWith:'**'},
        {name:'Italic', key:"I", openWith:'_', closeWith:'_'},
        {separator:'---------------'},
        {name:'Bulleted List', openWith:'- '},
        {name:'Numeric List', openWith:function(markItUp) {
            return markItUp.line+'. ';
        }},
        {separator:'---------------'},
        {
            name:'Create a Link',
            key:"L",
            openWith:'',
            closeWith:'',
            placeHolder:'',
            beforeInsert:function(h) {
                //alert('You selected "'+h.selection+'" ... '+"with "+h.openWith+" and "+h.closeWith+".");
            },
            afterInsert:function(h) {
                var text = (h.selection !== '') ? h.selection : 'Your links text';
    
                $('.' + $(h.textarea).attr('id') + '-link' + ' input').first().attr('value', text).focus();

                $('.' + $(h.textarea).attr('id') + '-link').dialog({
                    resizable: false,
                    height:400,
                    width: 550,
                    modal: true,
                    buttons: { }
                });
            }
        },
        {name:'Gallery', key:"G", openWith:'[gallery]'},
        {name:'Docs', key:"D", openWith:'[docs]'},
        {
            name:'Snippet',
            afterInsert:function(h) {
                $('.' + $(h.textarea).attr('id') + '-snippet').dialog({
                    resizable: false,
                    height:280,
                    width: 550,
                    modal: true,
                    buttons: { }
                });
            }
        },
        {separator:'---------------'},
        {name:'Separator', openWith:'\n////\n'},
        {name:'Shout', openWith:'![shout]\n\n', closeWith:'\n\n[/]'},
        {name:'Kicker', openWith:'![kicker]\n\n', closeWith:'\n\n[/]'}
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