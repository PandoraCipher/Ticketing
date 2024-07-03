<div class="container d-flex p-0">
    <label class="text-start" for="start_incident"><b>Incident start(if incident):&nbsp;</b></label>
    <label for="start_incident">{{ optional($ticket->intervention)->start_incident }}</label>
</div>
<div class="container d-flex p-0">
    <label class="text-start" for="start_operation"><b>Operation start:&nbsp;</b></label>
    <label for="start_operation">{{ optional($ticket->intervention)->start_interv }}</label>
</div>
<div class="container d-flex p-0">
    <label class="text-start" for="end_operation"><b>Operation end:&nbsp;</b></label>
    <label for="end_operation">{{ optional($ticket->intervention)->end_interv }}</label>
</div>
<div class="container d-flex p-0">
    <label class="text-start" for="end_operation"><b>Restore date:&nbsp;</b></label>
    <label for="end_operation">{{ optional($ticket->intervention)->restore_date }}</label>
</div>
