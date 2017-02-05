[[-- This is the template for the Evernote Export file --]]
@if(isset($start))
[[ '<'.'?'.'xml version="1.0" encoding="UTF-8"?>' ]]
<!DOCTYPE en-export SYSTEM "http://xml.evernote.com/pub/evernote-export3.dtd">
<en-export export-date="[[ date('omd').'T'.date('His').'Z' ]]" application="Paperwork">
@endif
    <note>
    <title>[[ $title ]]</title><content><![CDATA[<?xml version="1.0" encoding="UTF-8" standalone="no"?>
    <!DOCTYPE en-note SYSTEM "http://xml.evernote.com/pub/enml2.dtd">
    <en-note>

    [[ $content ]]
    @if(isset($attachments))
    @foreach ($attachments as $attachment)
        <en-media type="[[ $attachment['mimetype'] ]]" hash="[[ $attachment['hash'] ]]" /><br />
    @endforeach
    @endif
    </en-note>
    ]]>
    </content>
    <created>[[ $created ]]</created>
    <updated>[[ $updated ]]</updated>
    @if(isset($tags))
        @foreach ($tags as $tag)
            <tag>[[ $tag['title'] ]]</tag>
        @endforeach
    @endif
    <note-attributes>
        <author>[[ $firstname ]] [[ $lastname ]]</author>
        <reminder-order>0</reminder-order>
    </note-attributes>
    @if(isset($attachments))
    @foreach ($attachments as $attachment)
        <resource>
        <data encoding="base64">[[ $attachment['encoded'] ]]</data><mime>[[ $attachment['mimetype'] ]]</mime>
        <width>0</width><height>0</height>
        <resource-attributes><file-name>[[ $attachment['filename'] ]]</file-name></resource-attributes>
        </resource>
    @endforeach
    @endif
    </note>
@if(isset($end))
</en-export>
@endif
