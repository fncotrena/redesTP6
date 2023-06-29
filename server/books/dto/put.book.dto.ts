import { CreateUserDto } from "../../users/dto/create.user.dto";

export interface PutBookDto {
    id: string;
    title: string;
    autor: string;
    user:CreateUserDto;
}
