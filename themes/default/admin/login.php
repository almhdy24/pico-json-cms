<?php $this->layout('layouts/auth', ['title' => 'Admin Login']) ?>

<h1 class="title has-text-centered">Admin Login</h1>
<?php $this->insert('partials/flash', ['flash' => $flash ?? []]) ?>

<form method="POST" action="/admin/login">
  <div class="field">
    <label class="label">
      <i data-lucide="user"></i>
      <span>Username</span>
    </label>
    <div class="control">
      <input class="input" type="text" name="username" placeholder="Username" required>
    </div>
  </div>

  <div class="field">
    <label class="label">
      <i data-lucide="lock"></i>
      <span>Password</span>
    </label>
    <div class="control">
      <input class="input" type="password" name="password" placeholder="Password" required>
    </div>
  </div>

  <div class="field mt-4">
    <div class="control">
      <button class="button is-primary is-fullwidth" type="submit">
        <i data-lucide="log-in"></i>
        <span>Login</span>
      </button>
    </div>
  </div>
</form>