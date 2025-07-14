@extends('layouts')

@section('title', 'Pending Apartments Approval')

@section('content')
    <div class="container">
        <h2>Pending Apartments for Approval</h2>


        @if ($apartments->isEmpty())
            <p class="text-muted">No apartments pending approval.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Address</th>
                        <th>Owner</th>
                        <th>Available From</th>
                        <th>Available To</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartments as $apartment)
                        <tr>
                            <td>{{ $apartment->title }}</td>
                            <td>{{ $apartment->address }}</td>
                            <td>{{ $apartment->user->name }}</td>
                            <td>{{ $apartment->available_from }}</td>
                            <td>{{ $apartment->available_to }}</td>
                            <td>
                                {{-- Approve Button --}}
                                <button class="btn btn-success btn-sm d-inline-block me-2"
                                    onclick="showApproveModal({{ $apartment->id }})">
                                    Approve
                                </button>

                                {{-- Hidden Approve Form --}}
                                <form id="approve-form-{{ $apartment->id }}" method="POST"
                                    action="{{ route('admin.apartments.approve', $apartment->id) }}" style="display: none;">
                                    @csrf
                                    @method('PATCH')
                                </form>

                                {{-- Approve Modal --}}
                                <div id="approve-modal-{{ $apartment->id }}" class="custom-modal">
                                    <div class="modal-content">
                                        <p>Are you sure you want to approve this apartment?</p>
                                        <button class="btn btn-secondary btn-sm"
                                            onclick="closeApproveModal({{ $apartment->id }})">Cancel</button>
                                        <button class="btn btn-success btn-sm"
                                            onclick="submitApprove({{ $apartment->id }})">Yes, Approve</button>
                                    </div>
                                </div>

                                {{-- Hidden Delete Form --}}
                                <form id="delete-form-{{ $apartment->id }}" method="POST"
                                    action="{{ route('admin.apartments.destroy', $apartment->id) }}"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                {{-- Reject Button --}}
                                <button class="btn btn-danger btn-sm d-inline-block"
                                    onclick="showConfirm({{ $apartment->id }})">
                                    Reject
                                </button>

                                {{-- Reject Modal --}}
                                <div id="confirm-modal-{{ $apartment->id }}" class="custom-modal">
                                    <div class="modal-content">
                                        <p>Are you sure you want to reject and delete this apartment?</p>
                                        <button class="btn btn-secondary btn-sm"
                                            onclick="closeConfirm({{ $apartment->id }})">Cancel</button>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="submitDelete({{ $apartment->id }})">Yes, Delete</button>
                                    </div>
                                </div>
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
<style>
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        justify-content: center;
        align-items: center;
    }

    .custom-modal .modal-content {
        background: #fff;
        width: 550px;
        height: 150px;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .custom-modal .modal-content p {
        margin-bottom: 20px;
        font-weight: 500;
    }

    .custom-modal .modal-content button {
        width: 100px;
        margin: 5px;
    }
</style>


<script>
    function showConfirm(id) {
        document.getElementById('confirm-modal-' + id).style.display = 'flex';
    }

    function closeConfirm(id) {
        document.getElementById('confirm-modal-' + id).style.display = 'none';
    }

    function submitDelete(id) {
        document.getElementById('delete-form-' + id).submit();
    }

    // 👇 New for Approve Modal 👇
    function showApproveModal(id) {
        document.getElementById('approve-modal-' + id).style.display = 'flex';
    }

    function closeApproveModal(id) {
        document.getElementById('approve-modal-' + id).style.display = 'none';
    }

    function submitApprove(id) {
        document.getElementById('approve-form-' + id).submit();
    }
</script>

