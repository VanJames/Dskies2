    <?php echo CHtml::beginForm(CHtml::normalizeUrl(array("client/createTrial", "clientId" => $_REQUEST['clientId'])), 'POST'); ?>
        email:<input type="text" name="email" value="" ?>
        <input type="submit" value="提交">
        <span class="red"><?php if($duplicateEmail) echo "邮箱已存在"; ?></span>
    </form>