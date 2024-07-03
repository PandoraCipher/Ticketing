<div class="container d-flex p-0">
    <label class="text-start" for="start_incident"><b>Incident start(if incident):&nbsp;</b></label>
    <div class="form-container w-25 m-0 p-0">
        <input type="datetime-local" class="input text-dark" name="start_incident"
            value="{{ old('start_incident', optional($ticket->intervention)->start_incident) }}">
    </div>
</div>
<div class="container d-flex p-0">
    <label class="text-start" for="start_operation"><b>Operation start:&nbsp;</b></label>
    <div class="form-container w-25 m-0 p-0">
        <input type="datetime-local" class="input text-dark" name="start_operation"
            value="{{ old('start_operation', optional($ticket->intervention)->start_interv) }}">
    </div>
</div>
<div class="container d-flex p-0">
    <label class="text-start" for="end_operation"><b>Operation end:&nbsp;</b></label>
    <div class="form-container w-25 m-0 p-0">
        <input type="datetime-local" class="input text-dark" name="end_operation"
            value="{{ old('end_operation', optional($ticket->intervention)->end_interv) }}">
    </div>
</div>
<div class="container d-flex p-0">
    <label class="text-start" for="restore_date"><b>Restored date:&nbsp;</b></label>
    <div class="form-container w-25 m-0 p-0">
        <input type="datetime-local" class="input text-dark" name="restore_date"
            value="{{ old('restore_date', optional($ticket->intervention)->restore_date) }}">
    </div>
</div>
