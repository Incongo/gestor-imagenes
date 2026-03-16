<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3><?= $title ?></h3>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($user) ?>
                    <div class="mb-3">
                        <?= $this->Form->control('name', [
                            'class' => 'form-control',
                            'label' => 'Nombre completo',
                            'required' => true
                        ]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('email', [
                            'class' => 'form-control',
                            'label' => 'Email',
                            'required' => true
                        ]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('password', [
                            'class' => 'form-control',
                            'label' => 'Contraseña',
                            'type' => 'password',
                            'required' => true
                        ]) ?>
                    </div>
                    <div class="d-grid gap-2">
                        <?= $this->Form->button('Registrarse', [
                            'class' => 'btn btn-primary'
                        ]) ?>
                    </div>
                    <?= $this->Form->end() ?>

                    <hr>

                    <p class="text-center">
                        ¿Ya tienes cuenta?
                        <?= $this->Html->link('Inicia sesión', ['action' => 'login']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>