<div class="btn-group" role="group">
    @if($currentStatus == 'new')
        <button type="button" class="btn btn-warning" onclick="changeStatus('{{ $id }}', 'seen')">Просмотрено</button>
        <button type="button" class="btn btn-success" onclick="changeStatus('{{ $id }}', 'accepted')">Одобрено</button>
        <button type="button" class="btn btn-danger" onclick="changeStatus('{{ $id }}', 'denied')">Отклонено</button>
    @elseif($currentStatus == 'seen')
        <button type="button" class="btn btn-success" onclick="changeStatus('{{ $id }}', 'accepted')">Одобрено</button>
        <button type="button" class="btn btn-danger" onclick="changeStatus('{{ $id }}', 'denied')">Отклонено</button>
    @elseif($currentStatus == 'accepted')
        <button type="button" class="btn btn-warning" onclick="changeStatus('{{ $id }}', 'seen')">Просмотрено</button>
        <button type="button" class="btn btn-danger" onclick="changeStatus('{{ $id }}', 'denied')">Отклонено</button>
    @elseif($currentStatus == 'denied')
        <button type="button" class="btn btn-warning" onclick="changeStatus('{{ $id }}', 'seen')">Просмотрено</button>
        <button type="button" class="btn btn-success" onclick="changeStatus('{{ $id }}', 'accepted')">Одобрено</button>
    @endif
</div>