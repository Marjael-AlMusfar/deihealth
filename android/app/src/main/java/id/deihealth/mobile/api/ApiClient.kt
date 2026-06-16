package id.deihealth.mobile.api

import okhttp3.OkHttpClient
import okhttp3.logging.HttpLoggingInterceptor
import retrofit2.Retrofit
import retrofit2.converter.moshi.MoshiConverterFactory

object ApiClient {
    fun create(baseUrl: String, token: String? = null): DeiHealthApi {
        val logging = HttpLoggingInterceptor().apply { level = HttpLoggingInterceptor.Level.BASIC }
        val client = OkHttpClient.Builder()
            .addInterceptor(logging)
            .addInterceptor { chain ->
                val request = chain.request().newBuilder().apply {
                    token?.let { header("Authorization", "Bearer $it") }
                    header("Accept", "application/json")
                }.build()
                chain.proceed(request)
            }
            .build()

        return Retrofit.Builder()
            .baseUrl(baseUrl)
            .client(client)
            .addConverterFactory(MoshiConverterFactory.create())
            .build()
            .create(DeiHealthApi::class.java)
    }
}
