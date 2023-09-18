<div>
    <form wire:submit.prevent="send">
        <div class="row">
            <div class="col-sm-6 mb-3">
                <input class="form-control rounded-3 py-2 @error('arrayContact.name') is-invalid @enderror" type="text" placeholder="Nombre y Apellido" wire:model.defer="arrayContact.name">
            </div>
            <div class="col-sm-6 mb-3">
                <input class="form-control rounded-3 py-2 @error('arrayContact.email') is-invalid @enderror" type="email" placeholder="E-mail" wire:model.defer="arrayContact.email">
            </div>
        </div>
        <textarea class="form-control rounded-3 py-2 @error('arrayContact.message') is-invalid @enderror mb-3" placeholder="Mensaje" wire:model.defer="arrayContact.message"></textarea>
        <button type="submit" class="btn btn-dark rounded-3 py-3 lh-1 fs-sm-14 text-uppercase fw-600 px-5" wire:loading.attr="disabled" wire:target="send">Enviar mensaje <span wire:loading wire:target="send" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>

        @if ( $success )
            <div class="alert alert-success mt-3">Tu mensaje fue enviado. Responderemos a la brevedad. Muchas gracias.</div>
        @endif
    </form>
</div>