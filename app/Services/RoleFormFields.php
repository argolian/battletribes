<?php

namespace App\Services;

use App\Traits\RolesAndPermissionsHelpersTrait;

class RoleFormFields
{
    use RolesAndPermissionsHelpersTrait;

    protected $fieldList = [
        'name'          => '',
        'slug'          => '',
        'description'   => '',
        'level'         => '',
        'permissions'   => [],
    ];

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    public function handle()
    {
        $fields = $this->fieldList;
        $rolePermissionsIds = [];

        if ($this->id) {
            $fields = $this->fieldsFromModel($this->id, $fields);
            $rolePermissionsIds = $this->getRolePermissionsIds($this->id);
        }

        foreach ($fields as $fieldName => $fieldValue) {
            $fields[$fieldName] = old($fieldName, $fieldValue);
        }

        // Get the additional data for the form fields
        $roleFormFieldData = $this->roleFormFieldData();

        return array_merge(
            $fields,
            [
                'allPermissions'     => config('roles.models.permission')::all(),
                'rolePermissionsIds' => $rolePermissionsIds,
            ],
            $roleFormFieldData
        );
    }

    protected function fieldsFromModel($id, array $fields)
    {
        $role = config('roles.models.role')::findOrFail($id);

        $fieldNames = array_keys(array_except($fields, ['permissions']));

        $fields = [
            'id' => $id,
        ];
        foreach ($fieldNames as $field) {
            $fields[$field] = $role->{$field};
        }

        $fields['permissions'] = $role->permissions();

        return $fields;
    }

   protected function roleFormFieldData()
    {
        $allAvailablePermissions = config('roles.models.permission')::all();

        return [
            'allAvailablePermissions'   => $allAvailablePermissions,
        ];
    }
}
