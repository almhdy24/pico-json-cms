<?php $this->layout('layouts/admin', ['title' => 'Edit Post']) ?>

<section class="section">
  <div class="container">

    <div class="level">
      <div class="level-left">
        <h1 class="title">
          <i data-lucide="file-edit"></i>
          Edit Post
        </h1>
      </div>

      <div class="level-right">
        <div class="buttons">
          <a href="/admin" class="button is-light">
            <i data-lucide="arrow-left"></i>
            Back
          </a>

          <a
            href="/post/<?= htmlspecialchars($post['slug']) ?>"
            class="button is-link"
            target="_blank"
            rel="noopener"
          >
            <i data-lucide="eye"></i>
            View
          </a>
        </div>
      </div>
    </div>

    <form
      method="POST"
      action="/admin/edit/<?= $id ?>"
      class="box"
      id="postForm"
    >

      <!-- TITLE -->
      <div class="field">
        <label class="label" for="title">
          <i data-lucide="type"></i>
          Title *
        </label>

        <input
          id="title"
          class="input"
          type="text"
          name="title"
          value="<?= htmlspecialchars($post['title']) ?>"
          required
          autofocus
        >
      </div>

      <!-- CONTENT -->
      <div class="field">
        <label class="label" for="content">
          <i data-lucide="align-left"></i>
          Content *
        </label>

        <textarea
          id="content"
          class="textarea simple-editor"
          name="content"
          rows="15"
          placeholder="Write your post content here..."
          required
        ><?= htmlspecialchars($post['content']) ?></textarea>

        <p class="help">
          <i data-lucide="info"></i>
          <span id="wordCount">0 words</span>
        </p>
      </div>

      <!-- ACTIONS -->
      <div class="field is-grouped">
        <div class="control">
          <button class="button is-primary" type="submit">
            <i data-lucide="save"></i>
            Update Post
          </button>
        </div>

        <div class="control">
          <a class="button is-light" href="/admin">
            <i data-lucide="x"></i>
            Cancel
          </a>
        </div>
      </div>

    </form>
  </div>
</section>

<!-- EasyMDE via CDN -->
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css"
>

<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

  const textarea = document.querySelector('.simple-editor');
  const counter  = document.getElementById('wordCount');

  if (!textarea || typeof EasyMDE === 'undefined') return;

  const editor = new EasyMDE({
    element: textarea,
    spellChecker: false,
    forceSync: true,
    status: false,
    autofocus: true,
    toolbar: [
      "bold", "italic", "heading", "|",
      "unordered-list", "ordered-list", "|",
      "link", "image", "|",
      "preview", "fullscreen"
    ]
  });

  const updateCount = () => {
    const text  = editor.value().trim();
    const words = text ? text.split(/\s+/).length : 0;
    counter.textContent = `${words} words`;
  };

  editor.codemirror.on('change', updateCount);
  updateCount();

  // Trim content before submit
  document.getElementById('postForm').addEventListener('submit', () => {
    textarea.value = textarea.value.trim();
  });
});
</script>