@include('layouts.admin.head')

<body>
    @include('layouts.admin.navbar')
    @include('layouts.admin.sidebar')

    <div class="content-wrapper">
        <main class="container-fluid p-4">
            @yield('content')
        </main>
        @include('layouts.admin.footer')
    </div>

    <!-- Botão flutuante de theme (cog girando, como Duralux) -->
    <div class="theme-toggler position-fixed bottom-0 start-0 m-3">
        <button id="themeToggle" class="btn btn-primary rounded-circle"><i class="fas fa-cog fa-spin"></i></button>
        <div class="theme-panel d-none bg-white p-3 shadow">
            <h5>Theme Settings</h5>
            <div class="mb-3">
                <label>Navigation</label>
                <select id="navTheme" class="form-select">
                    <option>Light</option>
                    <option>Dark</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Header</label>
                <select id="headerTheme" class="form-select">
                    <option>Light</option>
                    <option>Dark</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Skins</label>
                <select id="skin" class="form-select">
                    <option>Light</option>
                    <option>Dark</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Typography</label>
                <select id="typography" class="form-select">
                    <option>Inter</option>
                    <option>Roboto</option>
                </select>
            </div>
            <button class="btn btn-secondary">Reset</button>
            <button class="btn btn-primary">Apply</button>
        </div>
    </div>

    <!-- Modais (mantidos, sem conflitos) -->
    @if(session('msg'))
        <div class="modal fade" id="successModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5>Sucesso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">{{ session('msg') }}</div>
                </div>
            </div>
        </div>
        <script>new bootstrap.Modal(document.getElementById('successModal')).show();</script>
    @endif
    @if($errors->any())
        <div class="modal fade" id="errorModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5>Erro(s)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <script>new bootstrap.Modal(document.getElementById('errorModal')).show();</script>
    @endif
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5>Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">Tem certeza?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Deletar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts do Duralux via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>
    <script>
        // Toggle do painel de theme
        document.getElementById('themeToggle').addEventListener('click', function() {
            document.querySelector('.theme-panel').classList.toggle('d-none');
        });

        // Mudar theme (light/dark)
        document.getElementById('skin').addEventListener('change', function(e) {
            document.documentElement.setAttribute('data-theme', e.target.value.toLowerCase());
        });

        // Mudar tipografia
        document.getElementById('typography').addEventListener('change', function(e) {
            document.body.style.fontFamily = e.target.value;
        });

        // APIs mantidas
        const nationalitySelect = document.getElementById('nationality');
        if (nationalitySelect) {
            fetch('/api/countries').then(res => res.json()).then(data => {
                data.forEach(country => {
                    const option = document.createElement('option');
                    option.value = `${country.name} (${country.code})`;
                    option.textContent = `${country.name} (${country.code})`;
                    nationalitySelect.appendChild(option);
                });
            });
        }

        // Phone code
        const phoneCodeMenu = document.getElementById('phone_code_menu');
        if (phoneCodeMenu) {
            fetch('/api/countries').then(res => res.json()).then(data => {
                data.forEach(country => {
                    if (country.phone) {
                        const li = document.createElement('li');
                        const a = document.createElement('a');
                        a.classList.add('dropdown-item');
                        a.textContent = `${country.name} (${country.phone})`;
                        a.addEventListener('click', e => {
                            e.preventDefault();
                            document.getElementById('selected_code').textContent = country.phone;
                            document.getElementById('phoneCode').value = country.phone;
                        });
                        li.appendChild(a);
                        phoneCodeMenu.appendChild(li);
                    }
                });
            });
        }

        // Delete confirmation
        document.addEventListener('click', e => {
            const btn = e.target.closest('.delete-btn');
            if (btn) {
                e.preventDefault();
                document.getElementById('confirmDeleteBtn').href = btn.dataset.url;
                new bootstrap.Modal(document.getElementById('deleteModal')).show();
            }
        });
    </script>
    @yield('scripts')
    @stack('scripts')
</body>
</html>