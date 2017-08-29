<?php include_once( 'partial/header_constructor_edit.php' ); ?>

<div class="container-inner">
  <div class="constructor-wrapper">
    <?php include_once( 'partial/rotate.php' ); ?>
    <div class="step-wrapper">
      <div class="title"><span>2</span>My jewellery model</div>
      <div class="jewellery-type">
        <div class="type">
          <input type="radio" name="type" id="type1" data-type="bracelet"/>
          <label for="type1">
            <div class="img"><img src="<?php includeImg('type-bracelet-1.svg'); ?>"></div>
            <p>Chain</p>
          </label>
        </div>
        <div class="type">
          <input type="radio" name="type" id="type2" data-type="bracelet"/>
          <label for="type2">
            <div class="img"><img src="<?php includeImg('type-bracelet-2.svg'); ?>"></div>
            <p>Firm</p>
          </label>
        </div>
        <div class="type">
          <input type="radio" name="type" id="type3" data-type="bracelet"/>
          <label for="type3">
            <div class="img"><img src="<?php includeImg('type-bracelet-3.svg'); ?>"></div>
            <p>String</p>
          </label>
        </div>
      </div>
      <div class="btns">
        <button class="back" onclick="window.location='constructor_step_1_edit.php'"><span></span>back</button>
        <button disabled><span></span>next step</button>
      </div>
    </div>
    <div class="constructor-edit-sidebar">
      <div class="title">my jewellery design:</div>
      <div class="edit-steps">
        <a href="constructor_step_1_edit.php" class="edit-step">
          <span><img src="<?php includeImg('edit-available.png'); ?>"></span>
          My jewellery
        </a>
        <a href="#" class="edit-step active">
          <span><img src="<?php includeImg('edit.png'); ?>"></span>
          My jewellery model
        </a>
        <a href="#" class="edit-step">
          <span>3</span>
          My jewellery material
        </a>
        <a href="#" class="edit-step">
          <span>4</span>
          My unique design
        </a>
        <a href="#" class="edit-step">
          <span>5</span>
          My order
        </a>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/scripts.php' ); ?>
</body>
</html>
