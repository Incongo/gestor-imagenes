<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3><?= $title ?></h3>
                </div>
                <div class="card-body">
                    <?= $this->Form->create() ?>
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
                        <?= $this->Form->button('Iniciar Sesión', [
                            'class' => 'btn btn-primary'
                        ]) ?>
                    </div>
                    <?= $this->Form->end() ?>

                    <hr>

                    <p class="text-center">
                        ¿No tienes cuenta?
                        <?= $this->Html->link('Regístrate aquí', ['action' => 'register']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>