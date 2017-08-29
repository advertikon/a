<?php include_once( 'partial/header_constructor_edit.php' ); ?>

<div class="container-inner">
  <div class="constructor-wrapper">
    <?php include_once( 'partial/rotate.php' ); ?>
    <div class="step-wrapper">
      <div class="title">
        <input type="text" placeholder="My Jewellery"/>
      </div>
      <div class="jewellery-type">
        <div class="type">
          <input type="radio" name="type" id="ring"/>
          <label for="ring">
            <div class="img"><img src="<?php includeImg('type-ring-1.svg'); ?>"></div>
            <p>Ring</p>
          </label>
        </div>
        <div class="type">
          <input type="radio" name="type" id="earrings"/>
          <label for="earrings">
            <div class="img"><img src="<?php includeImg('type-earrings-1.svg'); ?>"></div>
            <p>Earrings</p>
          </label>
        </div>
        <div class="type">
          <input type="radio" name="type" id="necklace"/>
          <label for="necklace">
            <div class="img"><img src="<?php includeImg('type-necklace-2.svg'); ?>"></div>
            <p>Necklace</p>
          </label>
        </div>
        <div class="type">
          <input type="radio" name="type" id="bracelet"/>
          <label for="bracelet">
            <div class="img"><img src="<?php includeImg('type-bracelet-3.svg'); ?>"></div>
            <p>Bracelet</p>
          </label>
        </div>
        <div class="type">
          <input type="radio" name="type" id="anklet"/>
          <label for="anklet">
            <div class="img"><img src="<?php includeImg('type-anklet-2.svg'); ?>"></div>
            <p>Anklet</p>
          </label>
        </div>
      </div>
      <div class="btns">
        <button disabled onclick="window.location='constructor_step_2.php'"><span></span>next step</button>
      </div>
    </div>
    <div class="constructor-edit-sidebar">
      <div class="title">my jewellery design:</div>
      <div class="edit-steps">
        <a href="#" class="edit-step active">
          <span><img src="<?php includeImg('edit.png'); ?>"></span>
          My jewellery
        </a>
        <a href="#" class="edit-step">
          <span>2</span>
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
<script type="text/javascript">
  $(function(){
    $('.jewellery-type input').click(function(){
      var id = $(this).attr('id');
      $('.btns button').attr('onclick',"window.location='constructor_step_2-"+id+".php'");
    })
  })
</script>
</body>
</html>
