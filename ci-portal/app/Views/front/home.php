<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="columns">
  <div class="column is-two-thirds">
    <form method="get" action="/search">
      <div class="field has-addons">
        <div class="control is-expanded">
          <input class="input" type="text" name="q" placeholder="Rechercher une application..." value="<?= esc($q ?? '') ?>">
        </div>
        <div class="control">
          <button class="button is-info" type="submit">Chercher</button>
        </div>
      </div>
    </form>

    <?php if (! empty($apps)): ?>
      <div class="box">
        <?php foreach ($apps as $app): ?>
          <div class="media">
            <div class="media-content">
              <p><strong><?= esc($app['name']) ?></strong> <small>(<?= esc($app['type']) ?>)</small></p>
              <div class="buttons">
                <?php if ($app['type'] === 'web'): ?>
                  <a class="button is-link" href="/otp/request?type=web&id=<?= (int)$app['id'] ?>">Accéder (OTP)</a>
                <?php else: ?>
                  <a class="button is-link" href="/otp/request?type=exe&id=<?= (int)$app['id'] ?>">Télécharger (OTP)</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <hr>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>Aucune application trouvée.</p>
    <?php endif; ?>
  </div>
  <div class="column">
    <div class="box">
      <h2 class="subtitle">Accès via OTP</h2>
      <form method="post" action="/otp/send">
        <div class="field">
          <label class="label">Email</label>
          <div class="control">
            <input class="input" type="email" name="email" required>
          </div>
        </div>
        <div class="field">
          <label class="label">Type</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select name="type">
                <option value="web">Application Web</option>
                <option value="exe">Exécutable Windows</option>
              </select>
            </div>
          </div>
        </div>
        <div class="field">
          <label class="label">Application ID</label>
          <div class="control">
            <input class="input" type="number" name="application_id" placeholder="ID">
          </div>
        </div>
        <div class="field">
          <button class="button is-primary" type="submit">Recevoir OTP</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

