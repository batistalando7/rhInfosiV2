{{-- resources/views/layouts/admin/theme-settings.blade.php --}}
<!-- Floating gear button -->
<button id="themeSettingsFloatingBtn" class="nxl-theme-gear btn btn-primary" title="Aparência" style="position:fixed; right:20px; top:50%; transform:translateY(-50%); z-index:1050;">
  <i class="fas fa-cog"></i>
</button>

<!-- Theme settings panel -->
<div id="duraluxThemePanel" class="card shadow-lg" style="width:320px; position:fixed; right:20px; top:50%; transform:translateY(-50%); z-index:1060; display:none;">
  <div class="card-header d-flex justify-content-between align-items-center">
    <strong>Configurações de Tema</strong>
    <button id="closeThemePanel" class="btn btn-sm btn-light"><i class="fas fa-times"></i></button>
  </div>
  <div class="card-body">
    <div class="mb-3">
      <label class="form-label">Tema Global</label>
      <div class="btn-group w-100" role="group">
        <button type="button" class="btn btn-outline-secondary theme-option" data-theme="light">Claro</button>
        <button type="button" class="btn btn-outline-secondary theme-option" data-theme="dark">Escuro</button>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Sidebar</label>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="sidebarDarkToggle">
        <label class="form-check-label" for="sidebarDarkToggle">Modo escuro na sidebar</label>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Navbar</label>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="navbarDarkToggle">
        <label class="form-check-label" for="navbarDarkToggle">Modo escuro na navbar</label>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Tipo de letra</label>
      <select id="fontSelect" class="form-select">
        <option value="default">Padrão</option>
        <option value="serif">Serif</option>
        <option value="mono">Monospace</option>
      </select>
    </div>

    <div class="d-flex justify-content-between">
      <button id="resetThemeSettings" class="btn btn-outline-danger">Repor Padrões</button>
      <button id="applyThemeSettings" class="btn btn-primary">Aplicar</button>
    </div>
  </div>
</div>
