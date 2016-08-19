/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
        { name: 'clipboard', groups: [ 'undo', 'clipboard' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'insert', groups: [ 'insert' ] },
        { name: 'forms', groups: [ 'forms' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'others', groups: [ 'others' ] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'blocks', 'indent', 'align', 'bidi', 'paragraph' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'about', groups: [ 'about' ] },
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] }
    ];

    config.removeButtons = 'Underline,Superscript,Undo,Redo,Cut,Copy,Anchor,Unlink,HorizontalRule,SpecialChar,Maximize,Subscript,RemoveFormat,About,Scayt,Styles,Paste,PasteFromWord,Indent,Outdent';
    config.format_tags = 'p;h1;h2;h3;pre';
    config.removeDialogTabs = 'image:advanced;link:advanced';

};
