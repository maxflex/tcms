<select class='form-control' ng-model='model' convert-to-number>
    <option ng-if='noneText' selected value='0'>@{{ noneText }}</option>
    <option ng-if='noneText' disabled>──────────────</option>
    <option
        ng-repeat='o in object'
        value='@{{ o.id }}'
    >@{{ o[label] }}</option>
</select>
