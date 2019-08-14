<?php


namespace Application;


class EditUserTransaction
{
    private $usersGateway;
    private $request;
    private $filesystem;

    public function __construct(UsersGateway $usersGateway, Request $request, Filesystem $filesystem)
    {
        $this->usersGateway = $usersGateway;
        $this->request = $request;
        $this->filesystem = $filesystem;
    }

    public function userEdit()
    {
        $imageFiles =  $this->request->getFile('image');
        $file = $imageFiles['name'];
        $file_loc = $imageFiles['tmp_name'];
        $folder = "../images/";
        $new_file_name = strtolower($file);
        $final_file = str_replace(' ', '-', $new_file_name);

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $gender = $this->request->getPost('gender');
        $mobileno = $this->request->getPost('mobileno');
        $designation = $this->request->getPost('designation');
        $idedit = $this->request->getPost('idedit');
        $image = $this->request->getPost('image');

        if ($this->filesystem->moveUploadedFile($file_loc, $folder . $final_file)) {
            $image = $final_file;
        }

        $this->usersGateway->updateByIdWithGender($name, $email, $gender, $mobileno, $designation, $image, $idedit);
    }
}