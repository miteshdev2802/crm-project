<div class="modal-body">
    <form action="javascript:void(0)" id="finalMerge" class="finalMerge" method="post">
        <input type="hidden" name="ids" id="sectedIds" value="{{$ids}}">
        <div class="form-radio"><b>Make Master &nbsp;</b><input class="form-radio-input makeMaster" name="makeMaster" type="radio" data-id="{{ $contacts[0]->id }}"></div>
        <h2 class="fs-5">{{$contacts[0]->name}}</h2>
        <p>{{$contacts[0]->email}}</p>
        <p>{{$contacts[0]->phone}}</p>
        <hr>
        <div class="form-radio"><b>Make Master &nbsp;</b><input class="form-radio-input makeMaster" name="makeMaster" type="radio" data-id="{{ $contacts[1]->id }}"></div>
        <h2 class="fs-5">{{$contacts[1]->name}}</h2>
        <p>{{$contacts[1]->email}}</p>
        <p>{{$contacts[1]->phone}}</p>
        <button type="submit" class="btn btn-primary" disabled="disable" id="mergeConfirm">Confirm Merge</button>
        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
    </form>
</div>