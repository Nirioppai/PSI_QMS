<div class="form-group">
  <div class="input-group input-group-alternative">
    <div class="input-group-prepend">
    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
  </div>
  {{Form::label($name, null, ['class' => 'control-label'])}}
  {{Form::textarea($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
</div>
</div>
