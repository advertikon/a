<?php include_once( 'partial/header_constructor.php' ); ?>

<div class="container-inner">
  <div class="constructor-wrapper">
    <?php include_once( 'partial/rotate.php' ); ?>
    <div class="step-wrapper">
      <div class="title"><span>2</span>My jewellery model</div>
      <div class="jewellery-type">
        <div class="type">
          <input type="radio" name="type" id="type1" data-type="earrings"/>
          <label for="type1">
            <div class="img"><img src="<?php includeImg('type-earrings-1.svg'); ?>"></div>
            <p>Stud</p>
          </label>
        </div>
        <div class="type">
          <input type="radio" name="type" id="type2" data-type="earrings"/>
          <label for="type2">
            <div class="img"><img src="<?php includeImg('type-earrings-2.svg'); ?>"></div>
            <p>Stud-Chain</p>
          </label>
        </div>
        <div class="type">
          <input type="radio" name="type" id="type3" data-type="earrings"/>
          <label for="type3">
            <div class="img"><img src="<?php includeImg('type-earrings-3.svg'); ?>"></div>
            <p>Dangle</p>
          </label>
        </div>
        <div class="type">
          <input type="radio" name="type" id="type4" data-type="earrings"/>
          <label for="type4">
            <div class="img"><img src="<?php includeImg('type-earrings-4.svg'); ?>"></div>
            <p>Dangle-Chain</p>
          </label>
        </div>
      </div>
      <div class="btns">
        <button class="back" onclick="window.location='constructor_step_1_edit.php'"><span></span>back</button>
        <button disabled><span></span>next step</button>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/scripts.php' ); ?>
</body>
</html>
