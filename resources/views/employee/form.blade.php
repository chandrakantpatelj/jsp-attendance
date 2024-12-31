<!-- resources/views/employee/form.blade.php -->
<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ isset($employee->id) ? route('employee.update', $employee->id) : route('employee.store') }}"
            method="POST">
            @csrf
            @if(isset($employee->id))
            @method('POST')
            @else
            @method('POST')
            @endif

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLabel">
                        {{ isset($employee->id) ? 'Edit Employee' : 'Create Employee' }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $employee->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $employee->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" id="position" name="position"
                            value="{{ old('position', $employee->position) }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($employee->id) ? 'Update' : 'Create' }} Employee
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>