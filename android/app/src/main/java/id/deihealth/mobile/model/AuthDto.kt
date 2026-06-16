package id.deihealth.mobile.model

import com.squareup.moshi.Json

data class RegisterRequest(
    val name: String,
    val email: String,
    val password: String,
    val role: String,
)

data class LoginRequest(
    val email: String,
    val password: String,
    @Json(name = "device_name") val deviceName: String,
)

data class LoginResponse(
    val token: String,
    val user: UserDto,
)

data class UserDto(
    val id: Long,
    val name: String,
    val email: String,
    val role: String,
)
