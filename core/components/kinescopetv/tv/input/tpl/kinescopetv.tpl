{$array = $modx->fromJSON($tv->value)}
{if is_array($array)}
    {$array['title'] = htmlspecialchars($array['title'])}
    {$array['desc'] = htmlspecialchars($array['desc'])}
{/if}
{$json = $modx->toJSON($array)}

<div id="actions-uploader-button">
	<div class="kinescope-tv__group">
        <input id="tv{$tv->id}" name="tv{$tv->id}" class="kinescope-tv x-form-textfield x-form-field" vlaue="{$tv->value}">
		<button class="kinescope-tv__button x-btn x-btn-small x-btn-icon-small-left primary-button x-btn-noicon" onclick="initOpenUploader()">Загрузить видео</button>
	</div>
</div>
<script type="text/javascript">
    // <![CDATA[
    {literal}
    Ext.onReady(function () {
        var fld = MODx.load({
            {/literal}
            xtype: 'textfield',
            applyTo: 'tv{$tv->id}',
            width: '99%',
            id: 'tv{$tv->id}',
            enableKeyEvents: true,
            allowBlank: {if $params.allowBlank == 1 || $params.allowBlank == 'true'}true{else}false{/if},
            value: '{$tv->value}',
            {literal}
            listeners: {'change': {fn: MODx.fireResourceFormChange, scope: this}},
        });
        Ext.getCmp('modx-panel-resource').getForm().add(fld);
        MODx.makeDroppable(fld);
    });
    {/literal}
    // ]]>
</script>

<div id="kinescope_tv_status">
    <div class="kinescope-tv__loader">
        <img src="{$modx->getOption('assets_url')}components/kinescopetv/img/loader.svg" alt="Loading">
    </div>
    <div class="kinescope-tv__message"></div>
</div>

<div id="uploader-widget"></div>