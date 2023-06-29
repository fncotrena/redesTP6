import { CreateUserDto } from "../../users/dto/create.user.dto";

export interface CreateBookDto {
    id: string;
    title: string;
    autor: string;
    user:CreateUserDto;
}
