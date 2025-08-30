<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="box">
  <form method="post" action="/otp/verify">
    <input type="hidden" name="type" value="<?= esc($type) ?>">
    <input type="hidden" name="application_id" value="<?= esc($app['id'] ?? 0) ?>">
    <div class="field">
      <label class="label">Email</label>
      <div class="control">
        <input class="input" type="email" name="email" required>
      </div>
    </div>
    <div class="field">
      <label class="label">Code OTP</label>
      <div class="control">
        <input class="input" type="text" name="code" maxlength="6" required>
      </div>
    </div>
    <div class="field">
      <button class="button is-primary" type="submit">Vérifier</button>
    </div>
  </form>
</div>
<?= $this->endSection() ?>

