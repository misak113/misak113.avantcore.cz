<?php //netteCache[01]000434a:2:{s:4:"time";s:21:"0.12412700 1342692184";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:111:"C:\Users\misak113\programing\internet\apache2.2\own_webs\misak113.avantcore.cz\app\templates\Site\default.latte";i:2;i:1342692131;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"94abcaa released on 2012-02-29";}}}?><?php

// source file: C:\Users\misak113\programing\internet\apache2.2\own_webs\misak113.avantcore.cz\app\templates\Site\default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'q8tvnpp5ff')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb76d978f707_content')) { function _lb76d978f707_content($_l, $_args) { extract($_args)
?><div id="banner">
	<h1>Misak113 - WEB</h1>
</div>

<div id="content">

	<div class="content-box">
		<h1>Počítače</h1>
		<table id="computers">
			<tr>
				<th>Název</th>
				<th>IP</th>
				<th>MAC</th>
				<th>Status</th>
			</tr>
<?php $iterations = 0; foreach ($computers as $name => $computer): ?>			<tr id="computer_<?php echo htmlSpecialChars($name) ?>">
				<td><?php echo Nette\Templating\Helpers::escapeHtml($name, ENT_NOQUOTES) ?></td>
				<td><?php echo Nette\Templating\Helpers::escapeHtml($computer['ip'], ENT_NOQUOTES) ?></td>
				<td><?php echo Nette\Templating\Helpers::escapeHtml($computer['mac'], ENT_NOQUOTES) ?></td>
				<td>
					<a href="#" id="computer_wakeOn_<?php echo htmlSpecialChars($name) ?>" class="computer_wakeOn" data-name="<?php echo htmlSpecialChars($name) ?>">
						<img src="<?php echo htmlSpecialChars($basePath) ?>/images/offline.gif" alt="offline" title="offline" id="computer_status_<?php echo htmlSpecialChars($name) ?>
" class="computer_status" data-name="<?php echo htmlSpecialChars($name) ?>" />
					</a>
				</td>

			</tr>
<?php $iterations++; endforeach ?>
		</table>
	</div>
	
</div>

<?php
}}

//
// block head
//
if (!function_exists($_l->blocks['head'][] = '_lb6c4290fbe9_head')) { function _lb6c4290fbe9_head($_l, $_args) { extract($_args)
?><script type="text/javascript" src="<?php echo htmlSpecialChars($basePath) ?>/js/misak.js"></script>

<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars())  ?>



<?php call_user_func(reset($_l->blocks['head']), $_l, get_defined_vars()) ; 